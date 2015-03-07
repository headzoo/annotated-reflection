<?php
namespace Headzoo\Reflection\Exception;

/**
 * Thrown when trying to access an annotation that can not be found on a
 * class, property, or method.
 */
class AnnotationNotFoundException
    extends AnnotationException {}