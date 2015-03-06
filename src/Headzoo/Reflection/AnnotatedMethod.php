<?php
namespace Headzoo\Reflection;

use ReflectionMethod;

class AnnotatedMethod
    extends ReflectionMethod
{
    /**
     * @var AnnotatedClass
     */
    private $declaring;

    /**
     * Constructor
     *
     * @param AnnotatedClass $declaring The declaring class
     * @param string                   $name      The name of the method
     */
    public function __construct($declaring, $name)
    {
        parent::__construct($declaring->getName(), $name);
        $this->declaring = $declaring;
    }

    /**
     * Gets declaring class for the reflected method
     *
     * @return AnnotatedClass
     */
    public function getDeclaringClass()
    {
        return $this->declaring;
    }

    /**
     * Gets the method prototype (if there is one)
     *
     * @return AnnotatedMethod
     */
    public function getPrototype()
    {
        $method = parent::getPrototype();
        if ($method) {
            $method = new self(
                new AnnotatedClass($method->getDeclaringClass()->getName()),
                $method->getName()
            );
        }

        return $method;
    }

    /**
     * Gets all of the method annotations
     *
     * @return array
     */
    public function getAnnotations()
    {
        return AnnotatedReflection::reader()->getMethodAnnotations($this);
    }

    /**
     * Gets a specific method annotation if it exists
     *
     * @param string $annotation The annotation
     *
     * @return null|object
     */
    public function getAnnotation($annotation)
    {
        return AnnotatedReflection::reader()->getMethodAnnotation($this, $annotation);
    }
}