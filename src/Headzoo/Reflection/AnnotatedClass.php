<?php
namespace Headzoo\Reflection;

use ReflectionClass;
use ReflectionProperty;
use ReflectionMethod;

/**
 * The ReflectionClass class reports information about a class, as well as the
 * class annotations.
 * 
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class AnnotatedClass
    extends ReflectionClass
{
    /**
     * @var bool|AnnotatedClass
     */
    private $parent = false;

    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var array
     */
    private $methods = [];

    /**
     * @var array
     */
    private $annotations = [];

    /**
     * @var array
     */
    private $annotated_properties = [];

    /**
     * @var array
     */
    private $annotated_methods = [];

    /**
     * @var array
     */
    private $property_annotations = [];

    /**
     * @var array
     */
    private $method_annotations = [];

    /**
     * @param object|string $class The name of a class or an object
     */
    public function __construct($class)
    {
        parent::__construct($class);
        $this->findAnnotations();
    }

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
        return $this->annotations;
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
        if (isset($this->annotations[$annotation])) {
            return $this->annotations[$annotation];
        }

        return null;
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
        $properties = $filter
            ? parent::getProperties($filter)
            : parent::getProperties();
        foreach($properties as &$property) {
            $property = $this->createAnnotatedProperty($property);
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
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
        
        return $this->createAnnotatedProperty(
            parent::getProperty($name)
        );
    }

    /**
     * Returns the annotations on the given property
     *
     * @param string $property The name of the property
     *
     * @return array
     */
    public function getPropertyAnnotations($property)
    {
        if (isset($this->property_annotations[$property])) {
            return $this->property_annotations[$property];
        }

        return [];
    }

    /**
     * Gets the properties that have the given annotation
     *
     * @param string $annotation      The annotation
     * @param bool   $gets_annotation True to return an array of AnnotatedProperty or false to get the annotation
     *
     * @return AnnotatedProperty[]
     */
    public function getPropertiesWithAnnotation($annotation, $gets_annotation = false)
    {
        if (isset($this->annotated_properties[$annotation])) {
            if ($gets_annotation) {
                $annotations = [];
                foreach($this->annotated_properties[$annotation] as $name => $property) {
                    $annotations[$name] = $property->getAnnotation($annotation);
                }
                return $annotations;
            } else {
                return $this->annotated_properties[$annotation];
            }
        }

        return [];
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
        $methods = $filter
            ? parent::getMethods($filter)
            : parent::getMethods();
        foreach($methods as &$method) {
            $method = $this->createAnnotatedMethod($method);
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
        if (isset($this->methods[$name])) {
            return $this->methods[$name];
        }
        
        return $this->createAnnotatedMethod(
            parent::getMethod($name)
        );
    }

    /**
     * Returns the annotations on the given method
     *
     * @param string $method The name of the method
     *
     * @return array
     */
    public function getMethodAnnotations($method)
    {
        if (isset($this->method_annotations[$method])) {
            return $this->method_annotations[$method];
        }

        return [];
    }

    /**
     * Gets the methods that have the given annotation
     *
     * @param string $annotation      The annotation
     * @param bool   $gets_annotation True to return an array of AnnotatedProperty or false to get the annotation
     *
     * @return AnnotatedMethod[]
     */
    public function getMethodsWithAnnotation($annotation, $gets_annotation = false)
    {
        if (isset($this->annotated_methods[$annotation])) {
            if ($gets_annotation) {
                $annotations = [];
                foreach($this->annotated_methods[$annotation] as $name => $method) {
                    $annotations[$name] = $method->getAnnotation($annotation);
                }
                return $annotations;
            } else {
                return $this->annotated_methods[$annotation];
            }
        }

        return [];
    }

    /**
     * Converts a ReflectionProperty into an AnnotatedProperty
     *
     * @param ReflectionProperty|string $property
     *
     * @return AnnotatedProperty
     */
    private function createAnnotatedProperty($property)
    {
        $name = ($property instanceof ReflectionProperty) ? $property->getName() : $property;
        if (!isset($this->properties[$name])) {
            $this->properties[$name] = new AnnotatedProperty(
                $this,
                $name,
                $this->getPropertyAnnotations($name)
            );
        }

        return $this->properties[$name];
    }

    /**
     * Converts a ReflectionMethod into an AnnotatedMethod
     *
     * @param ReflectionMethod|string $method
     *
     * @return AnnotatedMethod
     */
    private function createAnnotatedMethod($method)
    {
        $name = ($method instanceof ReflectionMethod) ? $method->getName() : $method;
        if (!isset($this->methods[$name])) {
            $this->methods[$name] = new AnnotatedMethod(
                $this,
                $name,
                $this->getMethodAnnotations($name)
            );
        }

        return $this->methods[$name];
    }

    /**
     * Finds the class annotations
     */
    private function findAnnotations()
    {
        foreach(AnnotatedReflection::reader()->getClassAnnotations($this) as $index => $annotation) {
            $this->annotations[$index] = $annotation;
        }
        if ($parent = $this->getParentClass()) {
            if ($annotations = $parent->getAnnotations()) {
                $this->annotations = array_merge($annotations, $this->annotations);
            }
        }
        
        foreach(parent::getProperties() as $property) {
            foreach(AnnotatedReflection::reader()->getPropertyAnnotations($property) as $index => $annotation) {
                $this->property_annotations[$property->getName()][$index] = $annotation;
            }
        }
        foreach($this->property_annotations as $name => $annotations) {
            foreach($annotations as $index => $annotation) {
                $this->annotated_properties[$index][$name] = $this->createAnnotatedProperty($name);
            }
        }
        
        foreach(parent::getMethods() as $method) {
            foreach(AnnotatedReflection::reader()->getMethodAnnotations($method) as $index => $annotation) {
                $this->method_annotations[$method->getName()][$index] = $annotation;
            }
        }
        foreach($this->method_annotations as $name => $annotations) {
            foreach($annotations as $index => $annotation) {
                $this->annotated_methods[$index][$name] = $this->createAnnotatedMethod($name);
            }
        }
    }
}