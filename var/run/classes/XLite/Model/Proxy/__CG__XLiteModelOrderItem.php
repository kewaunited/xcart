<?php

namespace XLite\Model\Proxy\__CG__\XLite\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class OrderItem extends \XLite\Model\OrderItem implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function __get($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', array($name));

        return parent::__get($name);
    }

    /**
     * {@inheritDoc}
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', array($name, $value));

        return parent::__set($name, $value);
    }

    /**
     * {@inheritDoc}
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__isset', array($name));

        return parent::__isset($name);

    }

    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'variant', 'capostParcelItems', 'capostReturnItems', 'xpcFakeItem', 'shippingCost', 'item_id', 'object', 'name', 'sku', 'price', 'itemNetPrice', 'discountedSubtotal', 'amount', 'order', 'surcharges', 'dumpProduct', 'attributeValues', 'total', 'subtotal');
        }

        return array('__isInitialized__', 'variant', 'capostParcelItems', 'capostReturnItems', 'xpcFakeItem', 'shippingCost', 'item_id', 'object', 'name', 'sku', 'price', 'itemNetPrice', 'discountedSubtotal', 'amount', 'order', 'surcharges', 'dumpProduct', 'attributeValues', 'total', 'subtotal');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (OrderItem $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getClearPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClearPrice', array());

        return parent::getClearPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function getClearWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClearWeight', array());

        return parent::getClearWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isValid', array());

        return parent::isValid();
    }

    /**
     * {@inheritDoc}
     */
    public function hasWrongAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasWrongAmount', array());

        return parent::hasWrongAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function renew()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'renew', array());

        return parent::renew();
    }

    /**
     * {@inheritDoc}
     */
    public function changeAmount($delta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'changeAmount', array($delta));

        return parent::changeAmount($delta);
    }

    /**
     * {@inheritDoc}
     */
    public function isPriceControlledServer()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPriceControlledServer', array());

        return parent::isPriceControlledServer();
    }

    /**
     * {@inheritDoc}
     */
    public function canChangeAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canChangeAmount', array());

        return parent::canChangeAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getExtendedDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExtendedDescription', array());

        return parent::getExtendedDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getProductAvailableAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductAvailableAmount', array());

        return parent::getProductAvailableAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function cloneEntity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', array());

        return parent::cloneEntity();
    }

    /**
     * {@inheritDoc}
     */
    public function setVariant(\XLite\Module\XC\ProductVariants\Model\ProductVariant $variant = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVariant', array($variant));

        return parent::setVariant($variant);
    }

    /**
     * {@inheritDoc}
     */
    public function getVariant()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVariant', array());

        return parent::getVariant();
    }

    /**
     * {@inheritDoc}
     */
    public function isFreeShipping()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isFreeShipping', array());

        return parent::isFreeShipping();
    }

    /**
     * {@inheritDoc}
     */
    public function addCapostParcelItem(\XLite\Module\XC\CanadaPost\Model\Order\Parcel\Item $newItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCapostParcelItem', array($newItem));

        return parent::addCapostParcelItem($newItem);
    }

    /**
     * {@inheritDoc}
     */
    public function addCapostReturnItem(\XLite\Module\XC\CanadaPost\Model\ProductsReturn\Item $newItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCapostReturnItem', array($newItem));

        return parent::addCapostReturnItem($newItem);
    }

    /**
     * {@inheritDoc}
     */
    public function addCapostParcelItems(\XLite\Module\XC\CanadaPost\Model\Order\Parcel\Item $capostParcelItems)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCapostParcelItems', array($capostParcelItems));

        return parent::addCapostParcelItems($capostParcelItems);
    }

    /**
     * {@inheritDoc}
     */
    public function getCapostParcelItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapostParcelItems', array());

        return parent::getCapostParcelItems();
    }

    /**
     * {@inheritDoc}
     */
    public function addCapostReturnItems(\XLite\Module\XC\CanadaPost\Model\ProductsReturn\Item $capostReturnItems)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCapostReturnItems', array($capostReturnItems));

        return parent::addCapostReturnItems($capostReturnItems);
    }

    /**
     * {@inheritDoc}
     */
    public function getCapostReturnItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCapostReturnItems', array());

        return parent::getCapostReturnItems();
    }

    /**
     * {@inheritDoc}
     */
    public function isXpcFakeItem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isXpcFakeItem', array());

        return parent::isXpcFakeItem();
    }

    /**
     * {@inheritDoc}
     */
    public function isDeleted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isDeleted', array());

        return parent::isDeleted();
    }

    /**
     * {@inheritDoc}
     */
    public function getProduct()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProduct', array());

        return parent::getProduct();
    }

    /**
     * {@inheritDoc}
     */
    public function isValidToClone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isValidToClone', array());

        return parent::isValidToClone();
    }

    /**
     * {@inheritDoc}
     */
    public function setXpcFakeItem($xpcFakeItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setXpcFakeItem', array($xpcFakeItem));

        return parent::setXpcFakeItem($xpcFakeItem);
    }

    /**
     * {@inheritDoc}
     */
    public function getXpcFakeItem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getXpcFakeItem', array());

        return parent::getXpcFakeItem();
    }

    /**
     * {@inheritDoc}
     */
    public function getShippingCost()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShippingCost', array());

        return parent::getShippingCost();
    }

    /**
     * {@inheritDoc}
     */
    public function setShippingCost($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShippingCost', array($value));

        return parent::setShippingCost($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setOrder(\XLite\Model\Order $order = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrder', array($order));

        return parent::setOrder($order);
    }

    /**
     * {@inheritDoc}
     */
    public function getItemPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemPrice', array());

        return parent::getItemPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function getItemNetPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemNetPrice', array());

        return parent::getItemNetPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function isOrderOpen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isOrderOpen', array());

        return parent::isOrderOpen();
    }

    /**
     * {@inheritDoc}
     */
    public function getThroughExcludeSurcharges()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getThroughExcludeSurcharges', array());

        return parent::getThroughExcludeSurcharges();
    }

    /**
     * {@inheritDoc}
     */
    public function setProduct(\XLite\Model\Product $product = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProduct', array($product));

        return parent::setProduct($product);
    }

    /**
     * {@inheritDoc}
     */
    public function setObject(\XLite\Model\Base\IOrderItem $item = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setObject', array($item));

        return parent::setObject($item);
    }

    /**
     * {@inheritDoc}
     */
    public function getAmountWarning($amount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAmountWarning', array($amount));

        return parent::getAmountWarning($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function setAmount($amount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAmount', array($amount));

        return parent::setAmount($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function getWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWeight', array());

        return parent::getWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function hasImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasImage', array());

        return parent::hasImage();
    }

    /**
     * {@inheritDoc}
     */
    public function getImageURL()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImageURL', array());

        return parent::getImageURL();
    }

    /**
     * {@inheritDoc}
     */
    public function getImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImage', array());

        return parent::getImage();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getURL()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getURL', array());

        return parent::getURL();
    }

    /**
     * {@inheritDoc}
     */
    public function isShippable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isShippable', array());

        return parent::isShippable();
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getKey', array());

        return parent::getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeValuesIds()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeValuesIds', array());

        return parent::getAttributeValuesIds();
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeValuesPlain()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeValuesPlain', array());

        return parent::getAttributeValuesPlain();
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeValuesAsString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeValuesAsString', array());

        return parent::getAttributeValuesAsString();
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeValuesCount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeValuesCount', array());

        return parent::getAttributeValuesCount();
    }

    /**
     * {@inheritDoc}
     */
    public function getSortedAttributeValues()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSortedAttributeValues', array());

        return parent::getSortedAttributeValues();
    }

    /**
     * {@inheritDoc}
     */
    public function isConfigured()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isConfigured', array());

        return parent::isConfigured();
    }

    /**
     * {@inheritDoc}
     */
    public function isValidAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isValidAmount', array());

        return parent::isValidAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function isActualAttributes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isActualAttributes', array());

        return parent::isActualAttributes();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrice($price)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrice', array($price));

        return parent::setPrice($price);
    }

    /**
     * {@inheritDoc}
     */
    public function setAttributeValues(array $attributeValues)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAttributeValues', array($attributeValues));

        return parent::setAttributeValues($attributeValues);
    }

    /**
     * {@inheritDoc}
     */
    public function hasAttributeValues()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasAttributeValues', array());

        return parent::hasAttributeValues();
    }

    /**
     * {@inheritDoc}
     */
    public function calculate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'calculate', array());

        return parent::calculate();
    }

    /**
     * {@inheritDoc}
     */
    public function getTaxable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTaxable', array());

        return parent::getTaxable();
    }

    /**
     * {@inheritDoc}
     */
    public function getTaxableBasis()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTaxableBasis', array());

        return parent::getTaxableBasis();
    }

    /**
     * {@inheritDoc}
     */
    public function getProductClass()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductClass', array());

        return parent::getProductClass();
    }

    /**
     * {@inheritDoc}
     */
    public function getEventCell()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEventCell', array());

        return parent::getEventCell();
    }

    /**
     * {@inheritDoc}
     */
    public function calculateTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'calculateTotal', array());

        return parent::calculateTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisplayTotal', array());

        return parent::getDisplayTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function calculateNetSubtotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'calculateNetSubtotal', array());

        return parent::calculateNetSubtotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getNetSubtotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNetSubtotal', array());

        return parent::getNetSubtotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getItemId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItemId', array());

        return parent::getItemId();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function setSku($sku)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSku', array($sku));

        return parent::setSku($sku);
    }

    /**
     * {@inheritDoc}
     */
    public function getSku()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSku', array());

        return parent::getSku();
    }

    /**
     * {@inheritDoc}
     */
    public function getPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrice', array());

        return parent::getPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setItemNetPrice($itemNetPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setItemNetPrice', array($itemNetPrice));

        return parent::setItemNetPrice($itemNetPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function setDiscountedSubtotal($discountedSubtotal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDiscountedSubtotal', array($discountedSubtotal));

        return parent::setDiscountedSubtotal($discountedSubtotal);
    }

    /**
     * {@inheritDoc}
     */
    public function getDiscountedSubtotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDiscountedSubtotal', array());

        return parent::getDiscountedSubtotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAmount', array());

        return parent::getAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotal', array());

        return parent::getTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubtotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubtotal', array());

        return parent::getSubtotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getObject()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getObject', array());

        return parent::getObject();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrder', array());

        return parent::getOrder();
    }

    /**
     * {@inheritDoc}
     */
    public function addSurcharges(\XLite\Model\OrderItem\Surcharge $surcharges)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addSurcharges', array($surcharges));

        return parent::addSurcharges($surcharges);
    }

    /**
     * {@inheritDoc}
     */
    public function getSurcharges()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurcharges', array());

        return parent::getSurcharges();
    }

    /**
     * {@inheritDoc}
     */
    public function addAttributeValues(\XLite\Model\OrderItem\AttributeValue $attributeValues)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAttributeValues', array($attributeValues));

        return parent::addAttributeValues($attributeValues);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeValues()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeValues', array());

        return parent::getAttributeValues();
    }

    /**
     * {@inheritDoc}
     */
    public function getNetPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNetPrice', array());

        return parent::getNetPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisplayPrice', array());

        return parent::getDisplayPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setTotal($total)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTotal', array($total));

        return parent::setTotal($total);
    }

    /**
     * {@inheritDoc}
     */
    public function setSubtotal($subtotal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubtotal', array($subtotal));

        return parent::setSubtotal($subtotal);
    }

    /**
     * {@inheritDoc}
     */
    public function getExcludeSurcharges()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExcludeSurcharges', array());

        return parent::getExcludeSurcharges();
    }

    /**
     * {@inheritDoc}
     */
    public function getIncludeSurcharges()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIncludeSurcharges', array());

        return parent::getIncludeSurcharges();
    }

    /**
     * {@inheritDoc}
     */
    public function getExcludeSurchargesByType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExcludeSurchargesByType', array($type));

        return parent::getExcludeSurchargesByType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getSurchargeTotals()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurchargeTotals', array());

        return parent::getSurchargeTotals();
    }

    /**
     * {@inheritDoc}
     */
    public function getSurchargeSum()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurchargeSum', array());

        return parent::getSurchargeSum();
    }

    /**
     * {@inheritDoc}
     */
    public function getSurchargeSumByType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurchargeSumByType', array($type));

        return parent::getSurchargeSumByType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getSurchargeTotalByType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurchargeTotalByType', array($type));

        return parent::getSurchargeTotalByType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function resetSurcharges()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'resetSurcharges', array());

        return parent::resetSurcharges();
    }

    /**
     * {@inheritDoc}
     */
    public function compareSurcharges(array $oldSurcharges)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'compareSurcharges', array($oldSurcharges));

        return parent::compareSurcharges($oldSurcharges);
    }

    /**
     * {@inheritDoc}
     */
    public function map(array $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'map', array($data));

        return parent::map($data);
    }

    /**
     * {@inheritDoc}
     */
    public function __unset($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__unset', array($name));

        return parent::__unset($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRepository', array());

        return parent::getRepository();
    }

    /**
     * {@inheritDoc}
     */
    public function checkCache()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'checkCache', array());

        return parent::checkCache();
    }

    /**
     * {@inheritDoc}
     */
    public function detach()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'detach', array());

        return parent::detach();
    }

    /**
     * {@inheritDoc}
     */
    public function __call($method, array $args = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', array($method, $args));

        return parent::__call($method, $args);
    }

    /**
     * {@inheritDoc}
     */
    public function setterProperty($property, $value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setterProperty', array($property, $value));

        return parent::setterProperty($property, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getterProperty($property)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getterProperty', array($property));

        return parent::getterProperty($property);
    }

    /**
     * {@inheritDoc}
     */
    public function isPersistent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPersistent', array());

        return parent::isPersistent();
    }

    /**
     * {@inheritDoc}
     */
    public function isDetached()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isDetached', array());

        return parent::isDetached();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueIdentifierName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniqueIdentifierName', array());

        return parent::getUniqueIdentifierName();
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueIdentifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUniqueIdentifier', array());

        return parent::getUniqueIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function update()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'update', array());

        return parent::update();
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'create', array());

        return parent::create();
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'delete', array());

        return parent::delete();
    }

    /**
     * {@inheritDoc}
     */
    public function processFiles($field, array $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'processFiles', array($field, $data));

        return parent::processFiles($field, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldsDefinition($class = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFieldsDefinition', array($class));

        return parent::getFieldsDefinition($class);
    }

    /**
     * {@inheritDoc}
     */
    public function prepareEntityBeforeCommit($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prepareEntityBeforeCommit', array($type));

        return parent::prepareEntityBeforeCommit($type);
    }

}
