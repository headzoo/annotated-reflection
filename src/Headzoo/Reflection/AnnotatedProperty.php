<?php
namespace Headzoo\Reflection;

use ReflectionProperty;

/**
 * The ReflectionProperty class reports information about classes
 * properties as well as the property annotations.
 * 
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class AnnotatedProperty
    extends ReflectionProperty
{
    use CommonTrait;
    
    /**
     * @var AnnotatedClass
     */
    private $declaring;

    /**
     * Constructor
     *
     * @param AnnotatedClass $declaring   The declaring class
     * @param string         $name        The name of the property
     * @param array          $annotations The property annotations if they are parsed already
     */
    public function __construct(AnnotatedClass $declaring, $name, array $annotations = [])
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
     * Gets declaring class
     *
     * @return AnnotatedClass
     */
    public function getDeclaringClass()
    {
        return $this->declaring;
    }

    /**
     * Finds the class annotations
     */
    private function findAnnotations()
    {
        foreach (AnnotatedReflection::reader()->getPropertyAnnotations($this) as $index => $annotation) {
            $this->annotations[$index] = $annotation;
        }
    }
}