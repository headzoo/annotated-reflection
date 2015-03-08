<?php
namespace Headzoo\Reflection;

/**
 * Stores reflection instances for classes, properties, and methods, so that only
 * one instance needs to be created.
 */
class Registry
    implements RegistryInterface
{
    /**
     * @var AnnotatedClass[]
     */
    protected $classes = [];

    /**
     * @var AnnotatedProperty[]
     */
    protected $properties = [];

    /**
     * @var AnnotatedMethod[]
     */
    protected $methods = [];

    /**
     * {@inheritdoc}
     */
    public function getClass($class)
    {
        $key = $this->buildKey($class);
        if (!isset($this->classes[$key])) {
            $this->classes[$key] = new AnnotatedClass($class); 
        }
        
        return $this->classes[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty($class, $property)
    {
        $key = $this->buildKey($class, $property);
        if (!isset($this->properties[$key])) {
            $class = $this->getClass($class);
            $this->properties[$key] = $class->getProperty($property);
        }
        
        return $this->properties[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod($class, $method)
    {
        $key = $this->buildKey($class, $method);
        if (!isset($this->methods[$key])) {
            $class = $this->getClass($class);
            $this->methods[$key] = $class->getMethod($method);
        }

        return $this->methods[$key];
    }

    /**
     * Builds a key for the local cache
     * 
     * @param string|object $class Name of the class
     * @param string        $child Name of the property or method
     *
     * @return string
     */
    protected function buildKey($class, $child = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        
        if (null === $child) {
            return $class;
        }
        
        return "{$class}::{$child}";
    }
}