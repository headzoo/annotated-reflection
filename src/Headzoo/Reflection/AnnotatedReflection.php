<?php
namespace Headzoo\Reflection;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\CacheProvider;
use ReflectionClass;

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
    private static $annotations = [];

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
     * Registers an annotation class
     * 
     * @param string $annotation The fully qualified class name
     *                           
     * @return bool
     */
    public static function registerAnnotation($annotation)
    {
        if (false === array_search($annotation, self::$annotations)) {
            $reflection = new ReflectionClass($annotation);
            AnnotationRegistry::registerFile($reflection->getFileName());
            self::$annotations[] = $annotation;
        }
        
        return true;
    }

    /**
     * Registers a group of annotations as an array
     * 
     * @param array $annotations Array of fully qualified class names
     *                           
     * @return bool
     */
    public static function registerAnnotations(array $annotations)
    {
        foreach($annotations as $annotation) {
            self::registerAnnotation($annotation);
        }
        
        return true;
    }

    /**
     * Returns the annotations that have been registered
     *
     * @return array
     */
    public static function getRegisteredAnnotations()
    {
        return self::$annotations;
    }

    /**
     * Returns a Reader instance
     *
     * @return Reader
     */
    public static function reader()
    {
        if (!self::$reader) {
            self::$reader = new AnnotationReader();
            self::$reader = new IndexedReader(new CachedReader(
                self::$reader,
                self::getCacheProvider()
            ));
        }

        return self::$reader;
    }
}