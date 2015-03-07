<?php
namespace Headzoo\Reflection;

/**
 * Stores reflection instances for classes, properties, and methods, so that only
 * one instance needs to be created.
 */
interface RegistryInterface
{
    /**
     * Returns an AnnotatedClass instance for the given class
     *
     * @param object|string $class Name of a class or an object
     *
     * @return AnnotatedClass
     */
    public function getClass($class);

    /**
     * Returns an AnnotatedProperty instance for the given class property
     *
     * @param object|string $class    Name of a class or an object
     * @param string        $property The name of the property
     *
     * @return AnnotatedProperty
     */
    public function getProperty($class, $property);

    /**
     * Returns a AnnotatedMethod instance for the given class method
     *
     * @param object|string $class  Name of a class or an object
     * @param string        $method The name of the method
     *
     * @return AnnotatedMethod
     */
    public function getMethod($class, $method);
}