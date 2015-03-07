<?php
namespace Headzoo\Reflection;

use ReflectionMethod;

/**
 * The ReflectionMethod class reports information about a method, as well
 * as the method annotations.
 * 
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class AnnotatedMethod
    extends ReflectionMethod
{
    use CommonTrait;
    
    /**
     * @var AnnotatedClass
     */
    private $declaring;

    /**
     * Constructor
     *
     * @param AnnotatedClass $declaring     The declaring class
     * @param string         $name          The name of the method
     * @param array          $annotations   The method annotations if they are parsed already
     */
    public function __construct($declaring, $name, array $annotations = [])
    {
        parent::__construct($declaring->getName(), $name);
        $this->declaring = $declaring;
        if ($annotations) {
            $this->annotations = $annotations;
        } else {
            $this->findAnnotations();
        }
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
     * Finds the class annotations
     */
    private function findAnnotations()
    {
        foreach (AnnotatedReflection::reader()->getMethodAnnotations($this) as $index => $annotation) {
            $this->annotations[$index] = $annotation;
        }
    }
}