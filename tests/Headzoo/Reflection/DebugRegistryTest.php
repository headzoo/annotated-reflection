<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\DebugRegistry;
use Headzoo\Reflection\AnnotatedProperty;
use Headzoo\Reflection\AnnotatedMethod;
use Headzoo\Reflection\AnnotatedClass;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Reflection\DebugRegistry
 */
class DebugRegistryTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var DebugRegistry
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
        $this->fixture = new DebugRegistry();
    }

    /**
     * @covers ::getClass
     * @covers ::getCreatedClasses
     * @covers ::getCachedClasses
     */
    public function testGetClass()
    {
        $reflection = $this->fixture->getClass(ParentPerson::class);
        $this->assertInstanceOf(
            AnnotatedClass::class,
            $reflection
        );
        $this->assertEquals(
            [ParentPerson::class],
            $this->fixture->getCreatedClasses()
        );
        $this->assertEquals(
            [],
            $this->fixture->getCachedClasses()
        );

        $this->fixture->getClass(ParentPerson::class);
        $this->assertEquals(
            [ParentPerson::class],
            $this->fixture->getCreatedClasses()
        );
        $this->assertEquals(
            [ParentPerson::class],
            $this->fixture->getCachedClasses()
        );

        $this->fixture->getClass(ParentPerson::class);
        $this->assertEquals(
            [ParentPerson::class, ParentPerson::class],
            $this->fixture->getCachedClasses()
        );
        
        $this->assertEquals(
            1,
            DebugRegistry::getInstanceCount()
        );
    }

    /**
     * @covers ::getMethod
     * @covers ::getCreatedMethods
     * @covers ::getCachedMethods
     */
    public function testGetMethod()
    {
        $reflection = $this->fixture->getMethod(ParentPerson::class, "getId");
        $this->assertInstanceOf(
            AnnotatedMethod::class,
            $reflection
        );
        $this->assertEquals(
            [ParentPerson::class . "::getId"],
            $this->fixture->getCreatedMethods()
        );
        $this->assertEquals(
            [],
            $this->fixture->getCachedMethods()
        );

        $this->fixture->getMethod(ParentPerson::class, "getId");
        $this->assertEquals(
            [ParentPerson::class . "::getId"],
            $this->fixture->getCreatedMethods()
        );
        $this->assertEquals(
            [ParentPerson::class . "::getId"],
            $this->fixture->getCachedMethods()
        );

        $this->fixture->getMethod(ParentPerson::class, "getId");
        $this->assertEquals(
            [ParentPerson::class . "::getId"],
            $this->fixture->getCreatedMethods()
        );
        $this->assertEquals(
            [ParentPerson::class . "::getId", ParentPerson::class . "::getId"],
            $this->fixture->getCachedMethods()
        );

        $this->assertEquals(
            2,
            DebugRegistry::getInstanceCount()
        );
    }

    /**
     * @covers ::getProperty
     * @covers ::getCreatedProperties
     * @covers ::getCachedProperties
     */
    public function testGetProperty()
    {
        $reflection = $this->fixture->getProperty(ParentPerson::class, "id");
        $this->assertInstanceOf(
            AnnotatedProperty::class,
            $reflection
        );
        $this->assertEquals(
            [ParentPerson::class . "::id"],
            $this->fixture->getCreatedProperties()
        );
        $this->assertEquals(
            [],
            $this->fixture->getCachedProperties()
        );

        $this->fixture->getProperty(ParentPerson::class, "id");
        $this->assertEquals(
            [ParentPerson::class . "::id"],
            $this->fixture->getCreatedProperties()
        );
        $this->assertEquals(
            [ParentPerson::class . "::id"],
            $this->fixture->getCachedProperties()
        );

        $this->fixture->getProperty(ParentPerson::class, "id");
        $this->assertEquals(
            [ParentPerson::class . "::id"],
            $this->fixture->getCreatedProperties()
        );
        $this->assertEquals(
            [ParentPerson::class . "::id", ParentPerson::class . "::id"],
            $this->fixture->getCachedProperties()
        );

        $this->assertEquals(
            3,
            DebugRegistry::getInstanceCount()
        );
    }
}