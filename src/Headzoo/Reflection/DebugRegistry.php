<?php
namespace Headzoo\Reflection;

/**
 * Reflection registry that provides debug/testing information.
 */
class DebugRegistry
    extends Registry
{
    /**
     * @var array
     */
    protected $created_classes = [];

    /**
     * @var array
     */
    protected $cached_classes = [];

    /**
     * @var array
     */
    protected $created_properties = [];

    /**
     * @var array
     */
    protected $cached_properties = [];

    /**
     * @var array
     */
    protected $created_methods = [];

    /**
     * @var array
     */
    protected $cached_methods = [];

    /**
     * Gets a list of classes that were created (cache miss)
     * 
     * @return array
     */
    public function getCreatedClasses()
    {
        return $this->created_classes;
    }

    /** Gets a list of classes that were cached (cache hit)
     * @return array
     */
    public function getCachedClasses()
    {
        return $this->cached_classes;
    }

    /**
     * Gets a list of properties that were created (cache miss)
     * 
     * @return array
     */
    public function getCreatedProperties()
    {
        return $this->created_properties;
    }

    /**
     * Gets a list of properties that were cached (cache hit)
     * 
     * @return array
     */
    public function getCachedProperties()
    {
        return $this->cached_properties;
    }

    /**
     * Gets a list of methods that were created (cache miss)
     * 
     * @return array
     */
    public function getCreatedMethods()
    {
        return $this->created_methods;
    }

    /**
     * Gets a list of methods that were cached (cache hit)
     * 
     * @return array
     */
    public function getCachedMethods()
    {
        return $this->cached_methods;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getClass($class)
    {
        $key = $this->buildKey($class);
        if (!isset($this->classes[$key])) {
            $this->created_classes[] = $key;
        } else {
            $this->cached_classes[] = $key;
        }
        
        return parent::getClass($class);
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty($class, $property)
    {
        $key = $this->buildKey($class, $property);
        if (!isset($this->properties[$key])) {
            $this->created_properties[] = $key;
        } else {
            $this->cached_properties[] = $key;
        }
        
        return parent::getProperty($class, $property);
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod($class, $method)
    {
        $key = $this->buildKey($class, $method);
        if (!isset($this->methods[$key])) {
            $this->created_methods[] = $key;
        } else {
            $this->cached_methods[] = $key;
        }

        return parent::getMethod($class, $method);
    }
}