<?php
namespace Headzoo\Reflection\Tests;

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