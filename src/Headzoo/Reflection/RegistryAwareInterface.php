<?php
namespace Headzoo\Reflection;

/**
 * Interface for classes which need a RegistryInterface instance.
 */
interface RegistryAwareInterface
{
    /**
     * Gets the object used to cache reflection instances
     *
     * @return RegistryInterface
     */
    public function getReflectionRegistry();

    /**
     * Sets the object to use as cache for reflection instances
     *
     * @param RegistryInterface $registry The registry
     *
     * @return $this
     */
    public function setReflectionRegistry(RegistryInterface $registry);
}