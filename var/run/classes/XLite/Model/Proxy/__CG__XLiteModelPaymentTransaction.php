<?php

namespace XLite\Model\Proxy\__CG__\XLite\Model\Payment;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Transaction extends \XLite\Model\Payment\Transaction implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'xpc_data', 'transaction_id', 'date', 'publicTxnId', 'method_name', 'method_local_name', 'status', 'value', 'note', 'type', 'public_id', 'order', 'payment_method', 'data', 'backend_transactions', 'currency', 'readableStatuses');
        }

        return array('__isInitialized__', 'xpc_data', 'transaction_id', 'date', 'publicTxnId', 'method_name', 'method_local_name', 'status', 'value', 'note', 'type', 'public_id', 'order', 'payment_method', 'data', 'backend_transactions', 'currency', 'readableStatuses');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Transaction $proxy) {
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
    public function isXpc($includeSavedCardsMethod = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isXpc', array($includeSavedCardsMethod));

        return parent::isXpc($includeSavedCardsMethod);
    }

    /**
     * {@inheritDoc}
     */
    public function isOpen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isOpen', array());

        return parent::isOpen();
    }

    /**
     * {@inheritDoc}
     */
    public function saveCard($first6, $last4, $type, $expireMonth = '', $expireYear = '')
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'saveCard', array($first6, $last4, $type, $expireMonth, $expireYear));

        return parent::saveCard($first6, $last4, $type, $expireMonth, $expireYear);
    }

    /**
     * {@inheritDoc}
     */
    public function getCard($forRechargesOnly = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCard', array($forRechargesOnly));

        return parent::getCard($forRechargesOnly);
    }

    /**
     * {@inheritDoc}
     */
    public function getInitXpcAction()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInitXpcAction', array());

        return parent::getInitXpcAction();
    }

    /**
     * {@inheritDoc}
     */
    public function getXpcValues()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getXpcValues', array());

        return parent::getXpcValues();
    }

    /**
     * {@inheritDoc}
     */
    public function getChargeValueModifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getChargeValueModifier', array());

        return parent::getChargeValueModifier();
    }

    /**
     * {@inheritDoc}
     */
    public function setXpcData(\XLite\Module\CDev\XPaymentsConnector\Model\Payment\XpcTransactionData $xpcData = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setXpcData', array($xpcData));

        return parent::setXpcData($xpcData);
    }

    /**
     * {@inheritDoc}
     */
    public function getXpcData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getXpcData', array());

        return parent::getXpcData();
    }

    /**
     * {@inheritDoc}
     */
    public function getProfile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProfile', array());

        return parent::getProfile();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrigProfile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrigProfile', array());

        return parent::getOrigProfile();
    }

    /**
     * {@inheritDoc}
     */
    public function prepareBeforeCreate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prepareBeforeCreate', array());

        return parent::prepareBeforeCreate();
    }

    /**
     * {@inheritDoc}
     */
    public function renewTransactionId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'renewTransactionId', array());

        return parent::renewTransactionId();
    }

    /**
     * {@inheritDoc}
     */
    public function setValue($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setValue', array($value));

        return parent::setValue($value);
    }

    /**
     * {@inheritDoc}
     */
    public function setPaymentMethod(\XLite\Model\Payment\Method $method = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPaymentMethod', array($method));

        return parent::setPaymentMethod($method);
    }

    /**
     * {@inheritDoc}
     */
    public function updateValue(\XLite\Model\Order $order)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'updateValue', array($order));

        return parent::updateValue($order);
    }

    /**
     * {@inheritDoc}
     */
    public function handleCheckoutAction()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'handleCheckoutAction', array());

        return parent::handleCheckoutAction();
    }

    /**
     * {@inheritDoc}
     */
    public function isCanceled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCanceled', array());

        return parent::isCanceled();
    }

    /**
     * {@inheritDoc}
     */
    public function isFailed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isFailed', array());

        return parent::isFailed();
    }

    /**
     * {@inheritDoc}
     */
    public function isCompleted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCompleted', array());

        return parent::isCompleted();
    }

    /**
     * {@inheritDoc}
     */
    public function isInProgress()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isInProgress', array());

        return parent::isInProgress();
    }

    /**
     * {@inheritDoc}
     */
    public function isPending()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPending', array());

        return parent::isPending();
    }

    /**
     * {@inheritDoc}
     */
    public function isVoid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isVoid', array());

        return parent::isVoid();
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthorized()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isAuthorized', array());

        return parent::isAuthorized();
    }

    /**
     * {@inheritDoc}
     */
    public function isCaptured()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCaptured', array());

        return parent::isCaptured();
    }

    /**
     * {@inheritDoc}
     */
    public function isRefunded()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isRefunded', array());

        return parent::isRefunded();
    }

    /**
     * {@inheritDoc}
     */
    public function isRefundedNotMulti()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isRefundedNotMulti', array());

        return parent::isRefundedNotMulti();
    }

    /**
     * {@inheritDoc}
     */
    public function isCaptureTransactionAllowed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCaptureTransactionAllowed', array());

        return parent::isCaptureTransactionAllowed();
    }

    /**
     * {@inheritDoc}
     */
    public function isVoidTransactionAllowed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isVoidTransactionAllowed', array());

        return parent::isVoidTransactionAllowed();
    }

    /**
     * {@inheritDoc}
     */
    public function isRefundTransactionAllowed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isRefundTransactionAllowed', array());

        return parent::isRefundTransactionAllowed();
    }

    /**
     * {@inheritDoc}
     */
    public function getReadableStatus($status = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReadableStatus', array($status));

        return parent::getReadableStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function setDataCell($name, $value, $label = NULL, $accessLevel = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDataCell', array($name, $value, $label, $accessLevel));

        return parent::setDataCell($name, $value, $label, $accessLevel);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataCell($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDataCell', array($name));

        return parent::getDataCell($name);
    }

    /**
     * {@inheritDoc}
     */
    public function createBackendTransaction($transactionType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'createBackendTransaction', array($transactionType));

        return parent::createBackendTransaction($transactionType);
    }

    /**
     * {@inheritDoc}
     */
    public function getInitialBackendTransaction()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInitialBackendTransaction', array());

        return parent::getInitialBackendTransaction();
    }

    /**
     * {@inheritDoc}
     */
    public function registerTransactionInOrderHistory($suffix = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'registerTransactionInOrderHistory', array($suffix));

        return parent::registerTransactionInOrderHistory($suffix);
    }

    /**
     * {@inheritDoc}
     */
    public function getHistoryEventDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHistoryEventDescription', array());

        return parent::getHistoryEventDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getHistoryEventDescriptionData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHistoryEventDescriptionData', array());

        return parent::getHistoryEventDescriptionData();
    }

    /**
     * {@inheritDoc}
     */
    public function getEventData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEventData', array());

        return parent::getEventData();
    }

    /**
     * {@inheritDoc}
     */
    public function isSameMethod(\XLite\Model\Payment\Method $method)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isSameMethod', array($method));

        return parent::isSameMethod($method);
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
    public function getNote()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNote', array());

        return parent::getNote();
    }

    /**
     * {@inheritDoc}
     */
    public function getTransactionId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTransactionId', array());

        return parent::getTransactionId();
    }

    /**
     * {@inheritDoc}
     */
    public function setDate($date)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDate', array($date));

        return parent::setDate($date);
    }

    /**
     * {@inheritDoc}
     */
    public function getDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDate', array());

        return parent::getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function setPublicTxnId($publicTxnId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPublicTxnId', array($publicTxnId));

        return parent::setPublicTxnId($publicTxnId);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublicTxnId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPublicTxnId', array());

        return parent::getPublicTxnId();
    }

    /**
     * {@inheritDoc}
     */
    public function setMethodName($methodName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMethodName', array($methodName));

        return parent::setMethodName($methodName);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMethodName', array());

        return parent::getMethodName();
    }

    /**
     * {@inheritDoc}
     */
    public function setMethodLocalName($methodLocalName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMethodLocalName', array($methodLocalName));

        return parent::setMethodLocalName($methodLocalName);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodLocalName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMethodLocalName', array());

        return parent::getMethodLocalName();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
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
    public function getValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValue', array());

        return parent::getValue();
    }

    /**
     * {@inheritDoc}
     */
    public function setNote($note)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNote', array($note));

        return parent::setNote($note);
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setType', array($type));

        return parent::setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', array());

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function setPublicId($publicId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPublicId', array($publicId));

        return parent::setPublicId($publicId);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublicId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPublicId', array());

        return parent::getPublicId();
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
    public function getOrder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrder', array());

        return parent::getOrder();
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentMethod()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPaymentMethod', array());

        return parent::getPaymentMethod();
    }

    /**
     * {@inheritDoc}
     */
    public function addData(\XLite\Model\Payment\TransactionData $data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addData', array($data));

        return parent::addData($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getData', array());

        return parent::getData();
    }

    /**
     * {@inheritDoc}
     */
    public function addBackendTransactions(\XLite\Model\Payment\BackendTransaction $backendTransactions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addBackendTransactions', array($backendTransactions));

        return parent::addBackendTransactions($backendTransactions);
    }

    /**
     * {@inheritDoc}
     */
    public function getBackendTransactions()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBackendTransactions', array());

        return parent::getBackendTransactions();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrency(\XLite\Model\Currency $currency = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCurrency', array($currency));

        return parent::setCurrency($currency);
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrency()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCurrency', array());

        return parent::getCurrency();
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
