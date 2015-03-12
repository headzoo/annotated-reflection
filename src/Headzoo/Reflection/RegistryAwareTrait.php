<?php
namespace Headzoo\Reflection;

/**
 * Implements RegistryAwareInterface.
 */
trait RegistryAwareTrait
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * {@inheritdoc}
     */
    public function getReflectionRegistry()
    {
        return $this->registry;
    }

    /**
     * {@inheritdoc}
     */
    public function setReflectionRegistry(RegistryInterface $registry)
    {
        $this->registry = $registry;

        return $this;
    }
}