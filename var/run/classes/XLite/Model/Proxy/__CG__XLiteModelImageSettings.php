<?php

namespace XLite\Model\Proxy\__CG__\XLite\Model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ImageSettings extends \XLite\Model\ImageSettings implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'id', 'code', 'model', 'width', 'height');
        }

        return array('__isInitialized__', 'id', 'code', 'model', 'width', 'height');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ImageSettings $proxy) {
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
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
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
    public function setCode($code)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCode', array($code));

        return parent::setCode($code);
    }

    /**
     * {@inheritDoc}
     */
    public function getCode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCode', array());

        return parent::getCode();
    }

    /**
     * {@inheritDoc}
     */
    public function setModel($model)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModel', array($model));

        return parent::setModel($model);
    }

    /**
     * {@inheritDoc}
     */
    public function getModel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModel', array());

        return parent::getModel();
    }

    /**
     * {@inheritDoc}
     */
    public function setWidth($width)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWidth', array($width));

        return parent::setWidth($width);
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWidth', array());

        return parent::getWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function setHeight($height)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHeight', array($height));

        return parent::setHeight($height);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHeight', array());

        return parent::getHeight();
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
