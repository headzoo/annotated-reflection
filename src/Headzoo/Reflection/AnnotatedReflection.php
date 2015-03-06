<?php
namespace Headzoo\Reflection;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;

/**
 * Used to configure the annotated reflection system.
 * 
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class AnnotatedReflection
{
    /**
     * @var CacheProvider
     */
    private static $provider;

    /**
     * @var array
     */
    private static $namespaces = [];

    /**
     * @var Reader
     */
    private static $reader;

    /**
     * Sets the object which caches annotations
     *
     * @param CacheProvider $provider The cache provider
     */
    public static function setCacheProvider(CacheProvider $provider)
    {
        self::$provider = $provider;
    }

    /**
     * Returns the set cache provider or an instance of ArrayCache when no provider is set
     *
     * @return CacheProvider
     */
    public static function getCacheProvider()
    {
        if (!self::$provider) {
            self::$provider = new ArrayCache();
        }

        return self::$provider;
    }

    /**
     * Registers an annotation namespace
     *
     * @param string            $namespace The namespace
     * @param string|array|null $dirs      One or more directories containing the namespace classes
     */
    public static function registerNamespace($namespace, $dirs = null)
    {
        if (null === $dirs) {
            $dirs = Directories::findSubDirectory("src", __DIR__);
            if (!$dirs) {
                $dirs = Directories::findSubDirectory("lib", __DIR__);
            }
        }
        
        AnnotationRegistry::registerAutoloadNamespace($namespace, $dirs);
        self::$namespaces[] = $namespace;
    }

    /**
     * Returns the namespaces that have been registered
     *
     * @return array
     */
    public static function getRegisteredNamespaces()
    {
        return self::$namespaces;
    }

    /**
     * Returns a Reader instance
     *
     * @return Reader
     */
    public static function reader()
    {
        if (!self::$reader) {
            self::$reader = new SimpleAnnotationReader();
            foreach (self::$namespaces as $namespace) {
                self::$reader->addNamespace($namespace);
            }
            self::$reader = new IndexedReader(new CachedReader(
                self::$reader,
                self::getCacheProvider()
            ));
        }

        return self::$reader;
    }
}