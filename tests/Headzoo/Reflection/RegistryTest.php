<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\Registry;
use Headzoo\Reflection\AnnotatedProperty;
use Headzoo\Reflection\AnnotatedMethod;
use Headzoo\Reflection\AnnotatedClass;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Reflection\Registry
 */
class RegistryTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var Registry
     */
    protected $fixture;

    /**
     * Called before any tests are run.
     */
    public static function setUpBeforeClass()
    {
        require_once(__DIR__ . "/assets/classes.php");
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->fixture = new Registry();
    }

    /**
     * @covers ::getClass
     */
    public function testGetClass()
    {
        $reflection = $this->fixture->getClass(ParentPerson::class);
        $this->assertInstanceOf(
            AnnotatedClass::class,
            $reflection
        );
        $this->assertSame(
            $reflection,
            $this->fixture->getClass(ParentPerson::class)
        );
        $this->assertNotSame(
            $reflection,
            $this->fixture->getClass(ChildPerson::class)
        );
    }

    /**
     * @covers ::getMethod
     */
    public function testGetMethod()
    {
        $reflection = $this->fixture->getMethod(ParentPerson::class, "getId");
        $this->assertInstanceOf(
            AnnotatedMethod::class,
            $reflection
        );
        $this->assertSame(
            $reflection,
            $this->fixture->getMethod(ParentPerson::class, "getId")
        );
    }

    /**
     * @covers ::getProperty
     */
    public function testGetProperty()
    {
        $reflection = $this->fixture->getProperty(ParentPerson::class, "id");
        $this->assertInstanceOf(
            AnnotatedProperty::class,
            $reflection
        );
        $this->assertSame(
            $reflection,
            $this->fixture->getProperty(ParentPerson::class, "id")
        );
    }
}