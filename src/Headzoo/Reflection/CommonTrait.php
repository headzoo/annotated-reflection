<?php
namespace Headzoo\Reflection;

/**
 * Common methods for each type of reflection.
 */
trait CommonTrait
{
    /**
     * @var array
     */
    protected $annotations = [];

    /**
     * Returns an array of every found annotation
     *
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * Gets a specific annotation if it exists
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
     * Returns a boolean value indicating whether the annotation exists
     *
     * @param string $annotation The annotation
     *
     * @return bool
     */
    public function hasAnnotation($annotation)
    {
        return isset($this->annotations[$annotation]);
    }
    
    /**
     * Gets a specific annotation or throws an exception when the annotation does not exist
     *
     * @param string $annotation The annotation
     *
     * @return null|object
     *
     * @throws Exception\AnnotationNotFoundException
     */
    public function mustGetAnnotation($annotation)
    {
        $obj = $this->getAnnotation($annotation);
        if (!$obj) {
            if ($this instanceof AnnotatedProperty) {
                $instance = $this->getDeclaringClass()->getName() . "::\$" . $this->getName();
            } else if ($this instanceof AnnotatedMethod) {
                $instance = $this->getDeclaringClass()->getName() . "::" . $this->getName() . "()";
            } else {
                $instance = $this->getName();
            }
            throw new Exception\AnnotationNotFoundException(sprintf(
                'Annotation "%s" not found on "%s". Did you forget a "use" statement?',
                $annotation,
                $instance
            ));
        }

        return $obj;
    }
}