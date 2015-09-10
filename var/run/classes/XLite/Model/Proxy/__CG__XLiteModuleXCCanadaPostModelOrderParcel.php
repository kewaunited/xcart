<?php

namespace XLite\Model\Proxy\__CG__\XLite\Module\XC\CanadaPost\Model\Order;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Parcel extends \XLite\Module\XC\CanadaPost\Model\Order\Parcel implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'number', 'status', 'oldStatus', 'quoteType', 'order', 'items', 'shipment', 'boxWeight', 'boxWidth', 'boxLength', 'boxHeight', 'isDocument', 'isUnpackaged', 'isMailingTube', 'isOversized', 'notifyOnShipment', 'notifyOnException', 'notifyOnDelivery', 'optSignature', 'optCoverage', 'optAgeProof', 'optWayToDeliver', 'optNonDelivery', 'apiCallErrors');
        }

        return array('__isInitialized__', 'id', 'number', 'status', 'oldStatus', 'quoteType', 'order', 'items', 'shipment', 'boxWeight', 'boxWidth', 'boxLength', 'boxHeight', 'isDocument', 'isUnpackaged', 'isMailingTube', 'isOversized', 'notifyOnShipment', 'notifyOnException', 'notifyOnDelivery', 'optSignature', 'optCoverage', 'optAgeProof', 'optWayToDeliver', 'optNonDelivery', 'apiCallErrors');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Parcel $proxy) {
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
    public function setOldStatus($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOldStatus', array($value));

        return parent::setOldStatus($value);
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
    public function addItem(\XLite\Module\XC\CanadaPost\Model\Order\Parcel\Item $newItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addItem', array($newItem));

        return parent::addItem($newItem);
    }

    /**
     * {@inheritDoc}
     */
    public function setShipment(\XLite\Module\XC\CanadaPost\Model\Order\Parcel\Shipment $shipment = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShipment', array($shipment));

        return parent::setShipment($shipment);
    }

    /**
     * {@inheritDoc}
     */
    public function cloneEntity($cloneItems = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cloneEntity', array($cloneItems));

        return parent::cloneEntity($cloneItems);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowedOptionClasses()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAllowedOptionClasses', array());

        return parent::getAllowedOptionClasses();
    }

    /**
     * {@inheritDoc}
     */
    public function getDeliveryService()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeliveryService', array());

        return parent::getDeliveryService();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($value));

        return parent::setStatus($value);
    }

    /**
     * {@inheritDoc}
     */
    public function canBeCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeCreated', array());

        return parent::canBeCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function canBeProposed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeProposed', array());

        return parent::canBeProposed();
    }

    /**
     * {@inheritDoc}
     */
    public function canBeTransmited()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeTransmited', array());

        return parent::canBeTransmited();
    }

    /**
     * {@inheritDoc}
     */
    public function hasShipment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasShipment', array());

        return parent::hasShipment();
    }

    /**
     * {@inheritDoc}
     */
    public function hasItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasItems', array());

        return parent::hasItems();
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
    public function getWeightInKg($adjustFloatValue = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWeightInKg', array($adjustFloatValue));

        return parent::getWeightInKg($adjustFloatValue);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxWeightInKg($adjustFloatValue = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxWeightInKg', array($adjustFloatValue));

        return parent::getBoxWeightInKg($adjustFloatValue);
    }

    /**
     * {@inheritDoc}
     */
    public function isOverWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isOverWeight', array());

        return parent::isOverWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function isEditable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isEditable', array());

        return parent::isEditable();
    }

    /**
     * {@inheritDoc}
     */
    public function isDeliveryToPostOffice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isDeliveryToPostOffice', array());

        return parent::isDeliveryToPostOffice();
    }

    /**
     * {@inheritDoc}
     */
    public function areAPICallsAllowed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'areAPICallsAllowed', array());

        return parent::areAPICallsAllowed();
    }

    /**
     * {@inheritDoc}
     */
    public function getApiCallErrors()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApiCallErrors', array());

        return parent::getApiCallErrors();
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
    public function setNumber($number)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumber', array($number));

        return parent::setNumber($number);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumber', array());

        return parent::getNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setQuoteType($quoteType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuoteType', array($quoteType));

        return parent::setQuoteType($quoteType);
    }

    /**
     * {@inheritDoc}
     */
    public function getQuoteType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuoteType', array());

        return parent::getQuoteType();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoxWeight($boxWeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoxWeight', array($boxWeight));

        return parent::setBoxWeight($boxWeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxWeight', array());

        return parent::getBoxWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoxWidth($boxWidth)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoxWidth', array($boxWidth));

        return parent::setBoxWidth($boxWidth);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxWidth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxWidth', array());

        return parent::getBoxWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoxLength($boxLength)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoxLength', array($boxLength));

        return parent::setBoxLength($boxLength);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxLength()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxLength', array());

        return parent::getBoxLength();
    }

    /**
     * {@inheritDoc}
     */
    public function setBoxHeight($boxHeight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBoxHeight', array($boxHeight));

        return parent::setBoxHeight($boxHeight);
    }

    /**
     * {@inheritDoc}
     */
    public function getBoxHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBoxHeight', array());

        return parent::getBoxHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsDocument($isDocument)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsDocument', array($isDocument));

        return parent::setIsDocument($isDocument);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsDocument()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsDocument', array());

        return parent::getIsDocument();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsUnpackaged($isUnpackaged)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsUnpackaged', array($isUnpackaged));

        return parent::setIsUnpackaged($isUnpackaged);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsUnpackaged()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsUnpackaged', array());

        return parent::getIsUnpackaged();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsMailingTube($isMailingTube)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsMailingTube', array($isMailingTube));

        return parent::setIsMailingTube($isMailingTube);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsMailingTube()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsMailingTube', array());

        return parent::getIsMailingTube();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsOversized($isOversized)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsOversized', array($isOversized));

        return parent::setIsOversized($isOversized);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsOversized()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsOversized', array());

        return parent::getIsOversized();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotifyOnShipment($notifyOnShipment)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotifyOnShipment', array($notifyOnShipment));

        return parent::setNotifyOnShipment($notifyOnShipment);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotifyOnShipment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotifyOnShipment', array());

        return parent::getNotifyOnShipment();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotifyOnException($notifyOnException)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotifyOnException', array($notifyOnException));

        return parent::setNotifyOnException($notifyOnException);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotifyOnException()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotifyOnException', array());

        return parent::getNotifyOnException();
    }

    /**
     * {@inheritDoc}
     */
    public function setNotifyOnDelivery($notifyOnDelivery)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNotifyOnDelivery', array($notifyOnDelivery));

        return parent::setNotifyOnDelivery($notifyOnDelivery);
    }

    /**
     * {@inheritDoc}
     */
    public function getNotifyOnDelivery()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNotifyOnDelivery', array());

        return parent::getNotifyOnDelivery();
    }

    /**
     * {@inheritDoc}
     */
    public function setOptSignature($optSignature)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOptSignature', array($optSignature));

        return parent::setOptSignature($optSignature);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptSignature()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOptSignature', array());

        return parent::getOptSignature();
    }

    /**
     * {@inheritDoc}
     */
    public function setOptCoverage($optCoverage)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOptCoverage', array($optCoverage));

        return parent::setOptCoverage($optCoverage);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptCoverage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOptCoverage', array());

        return parent::getOptCoverage();
    }

    /**
     * {@inheritDoc}
     */
    public function setOptAgeProof($optAgeProof)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOptAgeProof', array($optAgeProof));

        return parent::setOptAgeProof($optAgeProof);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptAgeProof()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOptAgeProof', array());

        return parent::getOptAgeProof();
    }

    /**
     * {@inheritDoc}
     */
    public function setOptWayToDeliver($optWayToDeliver)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOptWayToDeliver', array($optWayToDeliver));

        return parent::setOptWayToDeliver($optWayToDeliver);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptWayToDeliver()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOptWayToDeliver', array());

        return parent::getOptWayToDeliver();
    }

    /**
     * {@inheritDoc}
     */
    public function setOptNonDelivery($optNonDelivery)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOptNonDelivery', array($optNonDelivery));

        return parent::setOptNonDelivery($optNonDelivery);
    }

    /**
     * {@inheritDoc}
     */
    public function getOptNonDelivery()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOptNonDelivery', array());

        return parent::getOptNonDelivery();
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
    public function addItems(\XLite\Module\XC\CanadaPost\Model\Order\Parcel\Item $items)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addItems', array($items));

        return parent::addItems($items);
    }

    /**
     * {@inheritDoc}
     */
    public function getItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItems', array());

        return parent::getItems();
    }

    /**
     * {@inheritDoc}
     */
    public function getShipment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShipment', array());

        return parent::getShipment();
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
