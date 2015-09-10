<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\AuctionInc\Model\Shipping\Processor;

/**
 * Shipping processor model
 *
 * @see http://www.auctioninc.com/info/page/getting_started_api
 */
class AuctionInc extends \XLite\Model\Shipping\Processor\AProcessor
{
    /**
     * Cache ttl (for wrong response)
     */
    const CACHE_TTL = 1800;

    /**
     * Trial account id
     */
    const ACCOUNT_ID = '2fac8a0a8969284c8d27c29cb6e5d0fe';

    /**
     * Unique processor Id
     *
     * @var string
     */
    protected $processorId = 'auctionInc';

    /**
     * API connector
     *
     * @var \ShipRateAPI
     */
    protected $APIConnector = null;

    /**
     * Shipping methods
     *
     * @var \Doctrine\ORM\PersistentCollection
     */
    protected $methods = null;

    /**
     * Enabled shipping methods
     *
     * @var array
     */
    protected $enabledMethods = null;

    /**
     * Enabled shipping carriers
     *
     * @var array
     */
    protected $enabledCarriers = null;

    /**
     * Response cache
     *
     * @var array
     */
    protected $response = array();

    /**
     * getProcessorName
     *
     * @return string
     */
    public function getProcessorName()
    {
        return 'ShippingCalc';
    }

    /**
     * Get list of address fields required by shipping processor
     *
     * @return array
     */
    public function getRequiredAddressFields()
    {
        return array(
            'country_code',
            'state_id',
            'zipcode',
        );
    }

    /**
     * Returns processor's shipping methods rates
     *
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData   Shipping order modifier or array of data
     * @param boolean                                    $ignoreCache Flag: if true then do not get rates from
     *                                                                cache OPTIONAL
     *
     * @return array
     */
    public function getRates($inputData, $ignoreCache = false)
    {
        $this->errorMsg = null;
        $rates = array();

        $data = $this->prepareInputData($inputData);

        if (!empty($data)) {
            $rates = $this->doQuery($data, $ignoreCache);

        } else {
            $this->errorMsg = 'Wrong input data';
        }

        return $rates;
    }

    /**
     * doQuery
     *
     * @param array   $data        Data
     * @param boolean $ignoreCache Flag: if true then do not get rates from cache
     *
     * @return array
     */
    protected function doQuery($data, $ignoreCache)
    {
        $rates = array();

        $key = $this->getConfigurationFingerPrint() . serialize($data);

        if (!$ignoreCache) {
            $cachedResponse = $this->getDataFromCache($key);
        }

        $response = null;
        if (isset($cachedResponse)) {
            $response = $cachedResponse;

        } elseif (!\XLite\Model\Shipping::isIgnoreLongCalculations()) {
            $APIConnector = $this->getAPIConnector();
            $this->setRequestData($data);

            $status = false;

            if (\XLite\Module\XC\AuctionInc\Main::isSSAvailable()) {
                $status = $APIConnector->GetItemShipRateSS($response);

            } elseif (\XLite\Module\XC\AuctionInc\Main::isXSAvailable()) {
                $methods = $this->getEnabledMethods();
                if (count($methods)) {
                    $status = $APIConnector->GetItemShipRateXS($response);
                }
            }

            $this->logResponse($status, $data, $response);

            if ($status) {
                $this->saveDataInCache($key, $response);

                // drop selected shipping method to set it to cheapest
                if (!\XLite::isAdminZone()) {
                    /** @var \XLite\Model\Cart $cart */
                    $cart = \XLite::getController()->getCart();
                    $cart->setShippingId(0);
                    if ($cart->getProfile()) {
                        $cart->getProfile()->setLastShippingId(0);
                    }
                }
            } elseif (isset($response['ErrorList'])) {
                // report error
                $errorMessages = array();
                foreach ($response['ErrorList'] as $error) {
                    $errorMessages[] = $error['Message'];
                }

                $this->errorMsg = implode('; ', $errorMessages);
            }
        }

        if ($response && empty($this->errorMsg)) {
            $rates = $this->parseResponse($response);

        } else {
            $this->saveDataInCache($key, $response, static::CACHE_TTL);
        }

        if (!$response || empty($rates)) {
            // Apply fallback rate
            if (empty($rates) && 'N' != \XLite\Core\Config::getInstance()->XC->AuctionInc->fallbackRate) {
                $rateValue = $this->getFallbackRateValue($data['package']);

                $rate = new \XLite\Model\Shipping\Rate();
                $rate->setBaseRate($rateValue);

                $method = $this->findMethod('FF', 'FIXEDFEE', 'Fixed fee');

                $rate->setMethod($method);
                $rates[] = $rate;

                $this->errorMsg = null;
            }
        }

        return $rates;
    }

    /**
     * prepareInputData
     *
     * @param array|\XLite\Logic\Order\Modifier\Shipping $inputData Shipping order modifier (from order) or
     *                                                              array of input data (from test controller)
     *
     * @return array
     */
    protected function prepareInputData($inputData)
    {
        if ($inputData instanceof \XLite\Logic\Order\Modifier\Shipping) {
            $data = $this->prepareDataFromModifier($inputData);

        } else {
            $data = $inputData;
            $package = $data['package'];

            $item = array(
                'calculationMethod' => 'C',
                'sku'              => 'TEST',
                'name'              => 'Test item',
                'qty'               => 1,
                'weight'            => $package['weight'],
                'dimensions'        => array($package['length'], $package['width'], $package['height']),
                'weightUOM'         => 'LB',
                'dimensionsUOM'     => 'IN',
                'price'             => $package['subtotal'],
                'package'           => \XLite\Core\Config::getInstance()->XC->AuctionInc->package,
            );

            $package['items'] = array($item);

            $data['package'] = $package;
        }

        return $data;
    }

    /**
     * Prepare input data from order shipping modifier
     *
     * @param \XLite\Logic\Order\Modifier\Shipping $modifier Shipping order modifier
     *
     * @return array
     */
    protected function prepareDataFromModifier($modifier)
    {
        $result = array();
        /** @var \XLite\Model\Repo\State $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\State');

        $companyInfo = \XLite\Core\Config::getInstance()->Company;
        $stateCode =$repo->getCodeById($companyInfo->location_state);
        $result['srcAddress'] = array(
            'country' => $companyInfo->location_country,
            'zipcode' => $companyInfo->location_zipcode,
            'state'   => $stateCode,
        );

        $destinationAddress = \XLite\Model\Shipping::getInstance()->getDestinationAddress($modifier);
        if (isset($destinationAddress)) {
            $stateCode = $repo->getCodeById($destinationAddress['state']);

            $shippingAddress = $modifier->getOrder()->getProfile()
                ? $modifier->getOrder()->getProfile()->getShippingAddress()
                : null;

            $type = $shippingAddress && $shippingAddress->getType()
                ? $shippingAddress->getType()
                : \XLite\Core\Config::getInstance()->XC->AuctionInc->destinationType;

            $result['dstAddress'] = array(
                'country' => $destinationAddress['country'],
                'zipcode' => $destinationAddress['zipcode'],
                'state'   => $stateCode,
                'type'    => $type,
            );

            $result['items'] = $this->getItems($modifier);
        }

        return array('package' => $result);
    }

    /**
     * Collect items data from modifier
     *
     * @param \XLite\Logic\Order\Modifier\Shipping $modifier Shipping order modifier
     *
     * @return array
     */
    protected function getItems($modifier)
    {
        $result = array();

        /** @var \XLite\Model\OrderItem $item */
        foreach ($modifier->getItems() as $item) {
            $product = $item->getProduct();
            /** @var \XLite\Module\XC\AuctionInc\Model\ProductAuctionInc $auctionIncData */
            $auctionIncData = $product->getAuctionIncData()
                ?: new \XLite\Module\XC\AuctionInc\Model\ProductAuctionInc();

            $onDemand = array_map(function ($a) {
                list(, $serviceCode) = explode('_', $a);

                return $serviceCode;
            }, $auctionIncData->getOnDemand());

            $resultItem = array(
                'calculationMethod'      => $auctionIncData->getCalculationMethod(),
                'sku'                    => $product->getSku(),
                'name'                   => $product->getName(),
                'qty'                    => (int) $item->getAmount(),
                'weight'                 => $product->getWeight(),
                'weightUOM'              => $auctionIncData->getWeightUOM(),
                'dimensions'             => $auctionIncData->getDimensions(),
                'dimensionsUOM'          => $auctionIncData->getDimensionsUOM(),
                'package'                => $auctionIncData->getPackage(),
                'originCode'             => $auctionIncData->getOriginCode(),
                'onDemand'               => implode(', ', $onDemand),
                'carrierAccessorialFees' => implode(', ', $auctionIncData->getCarrierAccessorialFees())
            );

            $resultItem['price'] = ('Y' == $auctionIncData->getInsurable())
                ? ($item->getTotal() / $item->getAmount())
                : 0;

            if ('F' == $auctionIncData->getSupplementalItemHandlingMode()) {
                $resultItem['supplementalItemHandlingFee'] = $auctionIncData->getSupplementalItemHandlingFee();

            } elseif ('C' == $auctionIncData->getSupplementalItemHandlingMode()) {
                $resultItem['supplementalItemHandlingCode'] = $auctionIncData->getSupplementalItemHandlingCode();
            }

            if ('F' == $auctionIncData->getFixedFeeMode()) {
                $resultItem['fixedFee1'] = $auctionIncData->getFixedFee1();
                $resultItem['fixedFee2'] = $auctionIncData->getFixedFee2();

            } elseif ('C' == $auctionIncData->getFixedFeeMode()) {
                $resultItem['fixedFeeCode'] = $auctionIncData->getFixedFeeCode();
            }

            $result[] = $resultItem;
        }

        return $result;
    }

    /**
     * Set request data to API connector
     *
     * @param array $data Request data
     *
     * @return void
     */
    protected function setRequestData($data)
    {
        $APIConnector = $this->getAPIConnector();

        $package = $data['package'];

        // SSL currently not supported
        $APIConnector->setSecureComm(false);

        // curl option (use only if you have the libcurl package installed)
        $APIConnector->useCurl(false);

        //************************************************************
        // Set the Detail Level (1, 2 or 3) (Default = 1)
        // DL 1:  minimum required data returned
        // DL 2:  shipping rate components included
        // DL 3:  package-level detail included
        //************************************************************
        $detailLevel = 3;
        $APIConnector->setDetailLevel($detailLevel);

        //************************************************************
        // Set Currency
        // Determines the currency of the returned rates
        // and the expected currency of any monetary values set in your call
        // (declared value, item handling fee, fixed fees)
        //************************************************************
        $APIConnector->setCurrency(\XLite::getInstance()->getCurrency()->getCode());

        //************************************************************
        // Set Header Reference Code (optional)
        // can be used to identify and track a subset of calls,
        // such as a particular seller
        // (trackable in AuctionInc acct => API Statistics)
        //************************************************************
        if (\XLite\Module\XC\AuctionInc\Main::isXSAvailable()) {
            $APIConnector->setHeaderRefCode($this->getHeaderReferenceCode());
        }

        //**************************************************************
        // Set Origin Address/es for this Seller
        // (typically fed in from your seller account configuration)
        //**************************************************************
        if (\XLite\Module\XC\AuctionInc\Main::isXSAvailable() && $package['srcAddress']) {
            $APIConnector->addOriginAddress(
                $package['srcAddress']['country'],
                $package['srcAddress']['zipcode'],
                $package['srcAddress']['state']
            );
        }

        //************************************************************
        // Set Destination Address for this API call
        // (These values would typically come from your cart)
        //************************************************************
        if ($package['dstAddress']) {
            $APIConnector->setDestinationAddress(
                $package['dstAddress']['country'],
                $package['dstAddress']['zipcode'],
                $package['dstAddress']['state'],
                \XLite\View\FormField\Select\AddressType::TYPE_RESIDENTIAL === $package['dstAddress']['type']
            );
        }

        $this->setItemsData($package['items']);

        //*************************************************************
        // Set Carriers/Services to rate for this shipment
        // (on-demand flag is optional, see documentation)
        // (typically fed in from your seller account configuration)
        //*************************************************************
        $enabledCarriers = $this->getEnabledCarriers();
        foreach ($enabledCarriers as $carrier) {
            $entryPoint = \XLite\Core\Config::getInstance()->XC->AuctionInc->{'entryPoint' . $carrier};
            $APIConnector->addCarrier($carrier, $entryPoint);
        }

        $methods = $this->getEnabledMethods();
        /** @var \XLite\Model\Shipping\Method $method */
        foreach ($methods as $method) {
            list($carrierCode, $serviceCode) = explode('_', $method->getCode());

            $APIConnector->addService($carrierCode, $serviceCode, $method->getOnDemand());
        }
    }

    /**
     * Set (add) items data to API connector
     *
     * @param array $items Items
     *
     * @return void
     */
    protected function setItemsData($items)
    {
        foreach ($items as $item) {
            if ('C' == $item['calculationMethod']) {
                $this->setItemCarrierCalculation($item);

            } elseif ('F' == $item['calculationMethod']) {
                $this->setItemFixedFee($item);

            } elseif ('N' == $item['calculationMethod']) {
                $this->setItemFree($item);
            }
        }
    }

    /**
     * Set (add) item data to API connector
     *
     * @param array $item Item
     *
     * @return void
     */
    protected function setItemCarrierCalculation($item)
    {
        $APIConnector = $this->getAPIConnector();

        $dimensions = $item['dimensions'];

        $APIConnector->addItemCalc(
            $item['sku'],
            $item['qty'],
            $item['weight'],
            $item['weightUOM'],
            $dimensions[0],
            $dimensions[1],
            $dimensions[2],
            $item['dimensionsUOM'],
            $item['price'],
            $item['package']
        );

        if (\XLite\Module\XC\AuctionInc\Main::isSSAvailable()
            && isset($item['originCode'])
            && 'default' != $item['originCode']
        ) {
            $APIConnector->addItemOriginCode($item['originCode']);
        }

        if (isset($item['onDemand']) && $item['onDemand']) {
            $APIConnector->addItemOnDemandServices($item['onDemand']);
        }

        if (isset($item['carrierAccessorialFees']) && $item['carrierAccessorialFees']) {
            $APIConnector->addItemSpecialCarrierServices($item['carrierAccessorialFees']);
        }

        if (isset($item['supplementalItemHandlingFee'])) {
            $APIConnector->addItemHandlingFee($item['supplementalItemHandlingFee']);

        } elseif (isset($item['supplementalItemHandlingCode'])) {
            $APIConnector->addItemSuppHandlingCode($item['supplementalItemHandlingCode']);
        }
    }

    /**
     * Set (add) item data to API connector
     *
     * @param array $item Item
     *
     * @return void
     */
    protected function setItemFixedFee($item)
    {
        $APIConnector = $this->getAPIConnector();

        if (isset($item['fixedFee1']) && isset($item['fixedFee1'])) {
            $fixedFeeMode = 'F';
            $fixedFee1    = $item['fixedFee1'];
            $fixedFee2    = $item['fixedFee2'];
            $fixedFeeCode = '';
        } else {
            $fixedFeeMode = 'C';
            $fixedFee1    = 0;
            $fixedFee2    = 0;
            $fixedFeeCode = $item['fixedFeeCode'];
        }

        $APIConnector->addItemFixed(
            $item['name'],
            $item['qty'],
            $fixedFeeMode,
            $fixedFee1,
            $fixedFee2,
            $fixedFeeCode
        );

        if (isset($item['originCode'])) {
            $APIConnector->addItemOriginCode($item['originCode']);
        }
    }

    /**
     * Set (add) item data to API connector
     *
     * @param array $item Item
     *
     * @return void
     */
    protected function setItemFree($item)
    {
        $APIConnector = $this->getAPIConnector();
        $APIConnector->addItemFree($item['name'], $item['qty']);
    }

    /**
     * Returns rates array parsed from response
     *
     * @param array $response
     *
     * @return array
     */
    protected function parseResponse($response)
    {
        $rates = array();

        if (isset($response['ShipRate'])) {
            foreach ($response['ShipRate'] as $responseRate) {
                // UPS Next Day Air Early AM is a commercial only service.
                // Rather than ask you to implement differential code based
                // on the module Residential setting, lets just eliminate
                // this service method for the XS trial.
                // The two “Saturday” services have special handling in AuctionInc.
                // It would be best just to eliminate these two service methods as well for the XS trial
                $code = $responseRate['CarrierCode'] . '_' . $responseRate['ServiceCode'];
                if (!\XLite\Module\XC\AuctionInc\Main::isSSAvailable()
                    && in_array($code, array('UPS_UPSNDE', 'FEDEX_FDXPOS', 'UPS_UPSNDAS'))
                ) {
                    continue;
                }

                $rate = new \XLite\Model\Shipping\Rate();
                $rate->setBaseRate($responseRate['Rate']);
                $extraData = new \XLite\Core\CommonCell(array('auctionIncPackage' => $responseRate['PackageDetail']));
                $rate->setExtraData($extraData);

                $method = $this->findMethod(
                    $responseRate['CarrierCode'],
                    $responseRate['ServiceCode'],
                    $responseRate['ServiceName']
                );

                if ($method
                    && (\XLite\Module\XC\AuctionInc\Main::isSSAvailable() || $method->getEnabled())
                ) {
                    $rate->setMethod($method);
                    $rates[] = $rate;
                }
            }
        }

        return $rates;
    }

    /**
     * Calculate fallback rate value
     *
     * @param array $package Package
     *
     * @return float
     */
    protected function getFallbackRateValue($package)
    {
        $result = 0;
        $config = \XLite\Core\Config::getInstance()->XC->AuctionInc;
        $fallbackRateValue = $config->fallbackRateValue;

        if ('O' == $config->fallbackRate) {
            $result = $fallbackRateValue;

        } elseif ('I' == $config->fallbackRate) {
            foreach ($package['items'] as $item) {
                $result += $fallbackRateValue * $item['qty'];
            }
        }

        return $result;
    }

    /**
     * Returns shipping method
     *
     * @param string $carrierCode Carrier code
     * @param string $serviceCode Service code
     * @param string $serviceName Service name
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function findMethod($carrierCode, $serviceCode, $serviceName)
    {
        /** @var \XLite\Model\Repo\Shipping\Method $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');

        if (!isset($this->methods)) {
            $this->methods = $repo->findMethodsByProcessor($this->getProcessorId(), false);
        }

        $key = $carrierCode . '_' . $serviceCode;

        /**
         * @var \XLite\Model\Shipping\Method $method
         * @var \XLite\Model\Shipping\Method $carry
         * @var \XLite\Model\Shipping\Method $item
         */
        $method = array_reduce($this->methods, function ($carry, $item) use ($key) {
            return (!isset($carry) && $item->getCode() == $key)
                ? $item
                : $carry;
        }, null);

        if (!isset($method)) {
            $method = $repo->createShippingMethod(
                array(
                    'processor' => $this->getProcessorId(),
                    'carrier'   => $this->getProcessorId(),
                    'code'      => $key,
                    'enabled'   => true,
                    'position'  => 0,
                    'name'      => $serviceName,
                )
            );

            $this->methods[] = $method;
        }

        return $method;
    }

    /**
     * Returns API connector
     *
     * @return \ShipRateAPI
     */
    protected function getAPIConnector()
    {
        if (!isset($this->APIConnector)) {
            require_once LC_DIR_MODULES . 'XC' . LC_DS . 'AuctionInc' . LC_DS . 'lib' . LC_DS . 'ShipRateAPI.inc';

            $this->APIConnector = new \ShipRateAPI($this->getAccountId());
        }

        return $this->APIConnector;
    }

    /**
     * Returns account id
     *
     * @return string
     */
    protected function getAccountId()
    {
        return \XLite\Core\Config::getInstance()->XC->AuctionInc->accountId ?: static::ACCOUNT_ID;
    }

    /**
     * Returns header reference code
     *
     * @return string
     */
    protected function getHeaderReferenceCode()
    {
        return \XLite\Module\XC\AuctionInc\Main::getHeaderReferenceCode();
    }

    /**
     * Add log message
     *
     * @param boolean $status   Status
     * @param array   $request  Request data
     * @param array   $response Response data
     *
     * @return void
     */
    protected function logResponse($status, $request, $response)
    {
        if (\XLite\Core\Config::getInstance()->XC->AuctionInc->debugMode) {
            \XLite\Logger::logCustom('AuctionInc', array(
                'status' => $status,
                'request' => $request,
                'response' => $response
            ));
        }
    }

    /**
     * Returns configuration fingerprint
     *
     * @return string
     */
    protected function getConfigurationFingerPrint()
    {
        return serialize(\XLite\Core\Config::getInstance()->XC->AuctionInc->getData());
    }

    /**
     * Return enabled methods
     *
     * @return array
     */
    protected function getEnabledMethods()
    {
        if (!isset($this->enabledMethods)) {
            $this->enabledMethods = array();
            $enabledCarriers = $this->getEnabledCarriers();
            /** @var \XLite\Model\Repo\Shipping\Method $repo */
            $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');
            $methods = $repo->findMethodsByProcessor($this->getProcessorId());
            /** @var \XLite\Model\Shipping\Method $method */
            foreach ($methods as $method) {
                list($carrierCode, $serviceCode) = explode('_', $method->getCode());
                if (in_array($carrierCode, $enabledCarriers)) {
                    $this->enabledMethods[] = $method;
                }
            }
        }

        return $this->enabledMethods;
    }

    /**
     * Return enabled carriers
     *
     * @return array
     */
    protected function getEnabledCarriers()
    {
        if (!isset($this->enabledCarriers)) {
            $carriers = array('DHL', 'FEDEX', 'UPS', 'USPS');
            $this->enabledCarriers = array();
            foreach ($carriers as $carrier) {
                $entryPoint = \XLite\Core\Config::getInstance()->XC->AuctionInc->{'entryPoint' . $carrier};
                if (\XLite\Module\XC\AuctionInc\View\FormField\Select\AEntryPoint::STATE_DISABLED !== $entryPoint) {
                    $this->enabledCarriers[] = $carrier;
                }
            }
        }

        return $this->enabledCarriers;
    }
}
