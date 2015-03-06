<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\Annotation\Headzoo\AbstractAnnotation;
use Headzoo\Reflection\Annotation\Headzoo;
use Headzoo\Reflection\AnnotatedReflection;
use Headzoo\Reflection\AnnotatedProperty;
use Headzoo\Reflection\AnnotatedClass;
use Headzoo\Reflection\Annotation\Headzoo\Integer;
use Headzoo\Reflection\Annotation\Headzoo\Property;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Reflection\AnnotatedProperty
 */
class AnnotatedPropertyTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotatedProperty
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
        $class = new AnnotatedClass(ChildPerson::class);
        $this->fixture = $class->getProperty("counter");
    }

    /**
     * @covers ::getAnnotations
     */
    public function testGetAnnotations()
    {
        /** @var Headzoo\Property[] $annotations */
        $annotations = $this->fixture->getAnnotations();
        $this->assertCount(2, $annotations);
        $this->assertContainsOnlyInstancesOf(
            AbstractAnnotation::class,
            $annotations
        );
        $this->assertEquals(
            "public",
            $annotations[Property::class]->getValue()
        );
        $this->assertEquals(
            null,
            $annotations[Integer::class]->getValue()
        );
    }

    /**
     * @covers ::getAnnotation
     */
    public function testGetAnnotation()
    {
        $annotation = $this->fixture->getAnnotation(Headzoo\Property::class);
        $this->assertInstanceOf(
            Headzoo\Property::class,
            $annotation
        );

        $annotation = $this->fixture->getAnnotation(Headzoo\Method::class);
        $this->assertNull($annotation);
    }
}