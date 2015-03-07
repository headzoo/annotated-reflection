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
        if (is_object($class)) {
            $class = get_class($class);
        }
        if (!isset($this->classes[$class])) {
            $this->classes[$class] = new AnnotatedClass($class); 
        }
        
        return $this->classes[$class];
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty($class, $property)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        
        $key = "{$class}::{$property}";
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
        if (is_object($class)) {
            $class = get_class($class);
        }

        $key = "{$class}::{$method}";
        if (!isset($this->methods[$key])) {
            $class = $this->getClass($class);
            $this->methods[$key] = $class->getMethod($method);
        }

        return $this->methods[$key];
    }
}