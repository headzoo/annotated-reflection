<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\Annotation\Headzoo\AbstractAnnotation;
use Headzoo\Reflection\Annotation\Headzoo;
use Headzoo\Reflection\AnnotatedMethod;
use Headzoo\Reflection\AnnotatedProperty;
use Headzoo\Reflection\AnnotatedClass;
use Headzoo\Reflection\Annotation\Headzoo\Integer;
use Headzoo\Reflection\Annotation\Headzoo\Method;
use Headzoo\Reflection\Annotation\Headzoo\Property;
use Headzoo\Reflection\Annotation\Headzoo\TestPerson;
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
            $annotations[TestPerson::class]->getValue()
        );
        $this->assertEquals(
            "code_monkey",
            $annotations[TestPerson::class]->getJob()
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
     * @covers ::mustGetAnnotation
     * @expectedException \Headzoo\Reflection\Exception\AnnotationNotFoundException
     */
    public function testMustGetAnnotation()
    {
        $this->fixture->mustGetAnnotation(Headzoo\String::class);
    }

    /**
     * @covers ::hasAnnotation
     */
    public function testHasAnnotation()
    {
        $this->assertTrue(
            $this->fixture->hasAnnotation(Headzoo\TestClass::class)
        );
        $this->assertFalse(
            $this->fixture->hasAnnotation(Headzoo\String::class)
        );
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
     * @covers ::getPropertyAnnotations
     */
    public function testGetPropertyAnnotations()
    {
        $annotations = $this->fixture->getPropertyAnnotations("counter");
        $this->assertCount(2, $annotations);
        $this->assertArrayHasKey(
            Property::class,
            $annotations
        );
        $this->assertInstanceOf(
            Property::class,
            $annotations[Property::class]
        );
        $this->assertArrayHasKey(
            Integer::class,
            $annotations
        );
        $this->assertInstanceOf(
            Integer::class,
            $annotations[Integer::class]
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
            $properties["counter"]
        );

        $annotations = $this->fixture->getPropertiesWithAnnotation(Headzoo\Integer::class, true);
        $this->assertCount(3, $annotations);
        $this->assertInstanceOf(
            Headzoo\Integer::class,
            $annotations["counter"]
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
     * @covers ::getMethodAnnotations
     */
    public function testGetMethodAnnotations()
    {
        $annotations = $this->fixture->getMethodAnnotations("getCounter");
        $this->assertCount(1, $annotations);
        $this->assertArrayHasKey(
            Method::class,
            $annotations
        );
        $this->assertInstanceOf(
            Method::class,
            $annotations[Method::class]
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
            $methods["getCounter"]
        );

        $annotations = $this->fixture->getMethodsWithAnnotation(Headzoo\Method::class, true);
        $this->assertCount(3, $annotations);
        $this->assertInstanceOf(
            Method::class,
            $annotations["getCounter"]
        );
    }
}

