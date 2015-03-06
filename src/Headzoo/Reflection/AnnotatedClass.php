<?php
namespace Headzoo\Reflection;

use ReflectionClass;

class AnnotatedClass
    extends ReflectionClass
{
    /**
     * @var bool|AnnotatedClass
     */
    private $parent = false;

    /**
     * Gets parent class
     *
     * @return AnnotatedClass
     */
    public function getParentClass()
    {
        if (false === $this->parent) {
            $this->parent = parent::getParentClass();
            if ($this->parent) {
                $this->parent = new self($this->parent->getName());
            }
        }

        return $this->parent;
    }

    /**
     * Gets all of the class annotations
     *
     * @return array
     */
    public function getAnnotations()
    {
        $annotations = [];
        foreach(AnnotatedReflection::reader()->getClassAnnotations($this) as $annotation) {
            $annotations[] = $annotation;
        }
        if ($parent = $this->getParentClass()) {
            $parent_annotations = $parent->getAnnotations();
            if ($parent_annotations) {
                $annotations = array_merge($parent_annotations, $annotations);
            }
        }

        return $annotations;
    }

    /**
     * Gets a specific class annotation if it exists
     *
     * @param string $annotation The annotation
     *
     * @return null|object
     */
    public function getAnnotation($annotation)
    {
        $found = AnnotatedReflection::reader()->getClassAnnotation($this, $annotation);
        if (!$found && $parent = $this->getParentClass()) {
            $found = $parent->getAnnotation($annotation);
        }

        return $found;
    }

    /**
     * Gets properties
     *
     * @param null|int $filter The optional filter, for filtering desired property types
     *
     * @return AnnotatedProperty[]
     */
    public function getProperties($filter = null)
    {
        $properties = $filter ? parent::getProperties($filter) : parent::getProperties();
        foreach($properties as &$property) {
            $property = new AnnotatedProperty(
                $this,
                $property->getName()
            );
        }

        return $properties;
    }

    /**
     * Gets a AnnotatedReflectionProperty for a class's property
     *
     * @param string $name The property name
     *
     * @return AnnotatedProperty
     */
    public function getProperty($name)
    {
        $property = parent::getProperty($name);
        $property = new AnnotatedProperty(
            $this,
            $property->getName()
        );

        return $property;
    }

    /**
     * Gets the properties that have the given annotation
     *
     * @param string $annotation The annotation
     *
     * @return AnnotatedProperty[]
     */
    public function getPropertiesWithAnnotation($annotation)
    {
        $properties = [];
        foreach($this->getProperties() as $property) {
            if (AnnotatedReflection::reader()->getPropertyAnnotation($property, $annotation)) {
                $properties[] = $property;
            }
        }

        return $properties;
    }

    /**
     * Gets an array of methods
     *
     * @param null|int $filter Filter the results to include only methods with certain attributes
     *
     * @return AnnotatedMethod[]
     */
    public function getMethods($filter = null)
    {
        $methods = $filter ? parent::getMethods($filter) : parent::getMethods();
        foreach($methods as &$method) {
            $method = new AnnotatedMethod(
                $this,
                $method->getName()
            );
        }

        return $methods;
    }

    /**
     * Gets a AnnotatedReflectionMethod for a class method
     *
     * @param string $name The method name
     *
     * @return AnnotatedMethod
     */
    public function getMethod($name)
    {
        $method = parent::getMethod($name);
        $method = new AnnotatedMethod(
            $this,
            $method->getName()
        );

        return $method;
    }

    /**
     * Gets the methods that have the given annotation
     *
     * @param string $annotation The annotation
     *
     * @return AnnotatedMethod[]
     */
    public function getMethodsWithAnnotation($annotation)
    {
        $methods = [];
        foreach($this->getMethods() as $method) {
            if (AnnotatedReflection::reader()->getMethodAnnotation($method, $annotation)) {
                $methods[] = $method;
            }
        }

        return $methods;
    }
}