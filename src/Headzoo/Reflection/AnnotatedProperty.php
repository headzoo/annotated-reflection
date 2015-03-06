<?php
namespace Headzoo\Reflection;

use ReflectionProperty;

class AnnotatedProperty
    extends ReflectionProperty
{
    /**
     * @var AnnotatedClass
     */
    private $declaring;

    /**
     * Constructor
     *
     * @param AnnotatedClass $declaring The declaring class
     * @param string                   $name      The name of the property
     */
    public function __construct(AnnotatedClass $declaring, $name)
    {
        parent::__construct($declaring->getName(), $name);
        $this->declaring = $declaring;
    }

    /**
     * Gets declaring class
     *
     * @return AnnotatedClass
     */
    public function getDeclaringClass()
    {
        return $this->declaring;
    }

    /**
     * Gets all of the property annotations
     *
     * @return array
     */
    public function getAnnotations()
    {
        return AnnotatedReflection::reader()->getPropertyAnnotations($this);
    }

    /**
     * Gets a specific property annotation if it exists
     *
     * @param string $annotation The annotation
     *
     * @return null|object
     */
    public function getAnnotation($annotation)
    {
        return AnnotatedReflection::reader()->getPropertyAnnotation($this, $annotation);
    }
}