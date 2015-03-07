<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\AnnotatedReflection;
use Headzoo\Reflection\Annotation\Headzoo as Headzoo;
use Headzoo\Reflection\Annotation\Headzoo\Integer;
use Headzoo\Reflection\Annotation\Headzoo\Method;
use Headzoo\Reflection\Annotation\Headzoo\Property;
use Headzoo\Reflection\Annotation\Headzoo\TestClass;
use Headzoo\Reflection\Annotation\Headzoo\TestPerson;

AnnotatedReflection::registerAnnotations([
    Integer::class,
    Method::class,
    Property::class,
    TestPerson::class,
    TestClass::class
]);

/**
 * @Headzoo\TestPerson("headzoo", job="code_monkey")
 */
class ParentPerson
{
    /**
     * @Headzoo\Property
     * @Headzoo\Integer
     */
    public $id;

    /**
     * @Headzoo\Integer
     * @Headzoo\Method
     */
    public function getId() {}
}

/**
 * @Headzoo\TestClass
 */
class ChildPerson
    extends ParentPerson
{
    /**
     * @Headzoo\Property("public")
     * @Headzoo\Integer
     */
    public $counter;

    /**
     * @Headzoo\Property("protected")
     * @Headzoo\Integer
     */
    protected $start;

    /**
     * @Headzoo\Method("internal")
     */
    public function getCounter() {}

    /**
     * @Headzoo\Method
     */
    public function getStart() {}
}