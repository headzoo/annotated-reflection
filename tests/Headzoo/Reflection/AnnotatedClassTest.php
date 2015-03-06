<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\Annotation\Headzoo\AbstractAnnotation;
use Headzoo\Reflection\Annotation\Headzoo;
use Headzoo\Reflection\AnnotatedReflection;
use Headzoo\Reflection\AnnotatedMethod;
use Headzoo\Reflection\AnnotatedProperty;
use Headzoo\Reflection\AnnotatedClass;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Reflection\AnnotatedClass
 */
class AnnotatedClassTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotatedClass
     */
    protected $fixture;

    /**
     * Called before any tests are run.
     */
    public static function setUpBeforeClass()
    {
        require_once(__DIR__ . "/assets/classes.php");
        AnnotatedReflection::registerNamespace('Headzoo\Reflection\Annotation');
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->fixture = new AnnotatedClass(ChildPerson::class);
    }

    /**
     * @covers ::getParentClass
     */
    public function testGetParentClass()
    {
        $parent = $this->fixture->getParentClass();
        $this->assertInstanceOf(
            AnnotatedClass::class,
            $parent
        );
    }

    /**
     * @covers ::getAnnotations
     */
    public function testGetAnnotations()
    {
        /** @var Headzoo\TestPerson[] $annotations */
        $annotations = $this->fixture->getAnnotations();
        $this->assertCount(2, $annotations);
        $this->assertContainsOnlyInstancesOf(
            AbstractAnnotation::class,
            $annotations
        );
        $this->assertEquals(
            "headzoo",
            $annotations[0]->getValue()
        );
        $this->assertEquals(
            "code_monkey",
            $annotations[0]->getJob()
        );
    }

    /**
     * @covers ::getAnnotation
     */
    public function testGetAnnotation()
    {
        $annotation = $this->fixture->getAnnotation(Headzoo\TestClass::class);
        $this->assertInstanceOf(
            Headzoo\TestClass::class,
            $annotation
        );

        $annotation = $this->fixture->getAnnotation(Headzoo\String::class);
        $this->assertNull($annotation);
    }

    /**
     * @covers ::getProperties
     */
    public function testGetProperties()
    {
        /** @var AnnotatedProperty[] $properties */
        $properties = $this->fixture->getProperties();
        $this->assertCount(3, $properties);
        $this->assertContainsOnlyInstancesOf(
            AnnotatedProperty::class,
            $properties
        );
        $this->assertSame(
            $this->fixture,
            $properties[0]->getDeclaringClass()
        );
    }

    /**
     * @covers ::getProperty
     */
    public function testGetProperty()
    {
        $this->assertInstanceOf(
            AnnotatedProperty::class,
            $this->fixture->getProperty("counter")
        );
        $this->assertSame(
            $this->fixture,
            $this->fixture->getProperty("counter")->getDeclaringClass()
        );
    }

    /**
     * @covers ::getPropertiesWithAnnotation
     */
    public function testGetPropertiesWithAnnotation()
    {
        $properties = $this->fixture->getPropertiesWithAnnotation(Headzoo\Integer::class);
        $this->assertCount(3, $properties);
        $this->assertInstanceOf(
            AnnotatedProperty::class,
            $properties[0]
        );
    }

    /**
     * @covers ::getMethods
     */
    public function testGetMethods()
    {
        /** @var AnnotatedMethod[] $methods */
        $methods = $this->fixture->getMethods();
        $this->assertCount(3, $methods);
        $this->assertContainsOnlyInstancesOf(
            AnnotatedMethod::class,
            $methods
        );
        $this->assertSame(
            $this->fixture,
            $methods[0]->getDeclaringClass()
        );
    }

    /**
     * @covers ::getMethod
     */
    public function testGetMethod()
    {
        $this->assertInstanceOf(
            AnnotatedMethod::class,
            $this->fixture->getMethod("getCounter")
        );
        $this->assertSame(
            $this->fixture,
            $this->fixture->getMethod("getCounter")->getDeclaringClass()
        );
    }

    /**
     * @covers ::getMethodsWithAnnotation
     */
    public function testGetMethodsWithAnnotation()
    {
        $methods = $this->fixture->getMethodsWithAnnotation(Headzoo\Method::class);
        $this->assertCount(3, $methods);
        $this->assertInstanceOf(
            AnnotatedMethod::class,
            $methods[0]
        );
    }
}

