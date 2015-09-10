<?php

namespace XLite\Model\Proxy\__CG__\XLite\Module\XC\AuctionInc\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ProductAuctionInc extends \XLite\Module\XC\AuctionInc\Model\ProductAuctionInc implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'product', 'calculationMethod', 'package', 'dimensions', 'weightUOM', 'dimensionsUOM', 'insurable', 'originCode', 'onDemand', 'supplementalItemHandlingMode', 'supplementalItemHandlingCode', 'supplementalItemHandlingFee', 'carrierAccessorialFees', 'fixedFeeMode', 'fixedFeeCode', 'fixedFee1', 'fixedFee2');
        }

        return array('__isInitialized__', 'id', 'product', 'calculationMethod', 'package', 'dimensions', 'weightUOM', 'dimensionsUOM', 'insurable', 'originCode', 'onDemand', 'supplementalItemHandlingMode', 'supplementalItemHandlingCode', 'supplementalItemHandlingFee', 'carrierAccessorialFees', 'fixedFeeMode', 'fixedFeeCode', 'fixedFee1', 'fixedFee2');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ProductAuctionInc $proxy) {
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
    public function setWeight($weight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWeight', array($weight));

        return parent::setWeight($weight);
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
    public function setDimensions($dimensions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimensions', array($dimensions));

        return parent::setDimensions($dimensions);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimensions()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimensions', array());

        return parent::getDimensions();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setCalculationMethod($calculationMethod)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCalculationMethod', array($calculationMethod));

        return parent::setCalculationMethod($calculationMethod);
    }

    /**
     * {@inheritDoc}
     */
    public function getCalculationMethod()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCalculationMethod', array());

        return parent::getCalculationMethod();
    }

    /**
     * {@inheritDoc}
     */
    public function setPackage($package)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPackage', array($package));

        return parent::setPackage($package);
    }

    /**
     * {@inheritDoc}
     */
    public function getPackage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPackage', array());

        return parent::getPackage();
    }

    /**
     * {@inheritDoc}
     */
    public function setWeightUOM($weightUOM)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWeightUOM', array($weightUOM));

        return parent::setWeightUOM($weightUOM);
    }

    /**
     * {@inheritDoc}
     */
    public function getWeightUOM()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWeightUOM', array());

        return parent::getWeightUOM();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimensionsUOM($dimensionsUOM)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimensionsUOM', array($dimensionsUOM));

        return parent::setDimensionsUOM($dimensionsUOM);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimensionsUOM()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimensionsUOM', array());

        return parent::getDimensionsUOM();
    }

    /**
     * {@inheritDoc}
     */
    public function setInsurable($insurable)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInsurable', array($insurable));

        return parent::setInsurable($insurable);
    }

    /**
     * {@inheritDoc}
     */
    public function getInsurable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInsurable', array());

        return parent::getInsurable();
    }

    /**
     * {@inheritDoc}
     */
    public function setOriginCode($originCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOriginCode', array($originCode));

        return parent::setOriginCode($originCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getOriginCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOriginCode', array());

        return parent::getOriginCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setOnDemand($onDemand)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOnDemand', array($onDemand));

        return parent::setOnDemand($onDemand);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnDemand()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOnDemand', array());

        return parent::getOnDemand();
    }

    /**
     * {@inheritDoc}
     */
    public function setSupplementalItemHandlingMode($supplementalItemHandlingMode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSupplementalItemHandlingMode', array($supplementalItemHandlingMode));

        return parent::setSupplementalItemHandlingMode($supplementalItemHandlingMode);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupplementalItemHandlingMode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSupplementalItemHandlingMode', array());

        return parent::getSupplementalItemHandlingMode();
    }

    /**
     * {@inheritDoc}
     */
    public function setSupplementalItemHandlingCode($supplementalItemHandlingCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSupplementalItemHandlingCode', array($supplementalItemHandlingCode));

        return parent::setSupplementalItemHandlingCode($supplementalItemHandlingCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupplementalItemHandlingCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSupplementalItemHandlingCode', array());

        return parent::getSupplementalItemHandlingCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setSupplementalItemHandlingFee($supplementalItemHandlingFee)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSupplementalItemHandlingFee', array($supplementalItemHandlingFee));

        return parent::setSupplementalItemHandlingFee($supplementalItemHandlingFee);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupplementalItemHandlingFee()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSupplementalItemHandlingFee', array());

        return parent::getSupplementalItemHandlingFee();
    }

    /**
     * {@inheritDoc}
     */
    public function setCarrierAccessorialFees($carrierAccessorialFees)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCarrierAccessorialFees', array($carrierAccessorialFees));

        return parent::setCarrierAccessorialFees($carrierAccessorialFees);
    }

    /**
     * {@inheritDoc}
     */
    public function getCarrierAccessorialFees()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCarrierAccessorialFees', array());

        return parent::getCarrierAccessorialFees();
    }

    /**
     * {@inheritDoc}
     */
    public function setFixedFeeMode($fixedFeeMode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFixedFeeMode', array($fixedFeeMode));

        return parent::setFixedFeeMode($fixedFeeMode);
    }

    /**
     * {@inheritDoc}
     */
    public function getFixedFeeMode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFixedFeeMode', array());

        return parent::getFixedFeeMode();
    }

    /**
     * {@inheritDoc}
     */
    public function setFixedFeeCode($fixedFeeCode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFixedFeeCode', array($fixedFeeCode));

        return parent::setFixedFeeCode($fixedFeeCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getFixedFeeCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFixedFeeCode', array());

        return parent::getFixedFeeCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setFixedFee1($fixedFee1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFixedFee1', array($fixedFee1));

        return parent::setFixedFee1($fixedFee1);
    }

    /**
     * {@inheritDoc}
     */
    public function getFixedFee1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFixedFee1', array());

        return parent::getFixedFee1();
    }

    /**
     * {@inheritDoc}
     */
    public function setFixedFee2($fixedFee2)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFixedFee2', array($fixedFee2));

        return parent::setFixedFee2($fixedFee2);
    }

    /**
     * {@inheritDoc}
     */
    public function getFixedFee2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFixedFee2', array());

        return parent::getFixedFee2();
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
    public function getProduct()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProduct', array());

        return parent::getProduct();
    }

    /**
     * {@inheritDoc}
     */
    public function getNetSupplementalItemHandlingFee()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNetSupplementalItemHandlingFee', array());

        return parent::getNetSupplementalItemHandlingFee();
    }

    /**
     * {@inheritDoc}
     */
    public function getNetFixedFee1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNetFixedFee1', array());

        return parent::getNetFixedFee1();
    }

    /**
     * {@inheritDoc}
     */
    public function getNetFixedFee2()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNetFixedFee2', array());

        return parent::getNetFixedFee2();
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
    public function cloneEntity()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', array());

        return parent::cloneEntity();
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