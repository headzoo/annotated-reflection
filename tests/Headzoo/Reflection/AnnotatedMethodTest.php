<?php
namespace Headzoo\Reflection\Tests;

use Headzoo\Reflection\Annotation\Headzoo\AbstractAnnotation;
use Headzoo\Reflection\Annotation\Headzoo;
use Headzoo\Reflection\AnnotatedReflection;
use Headzoo\Reflection\AnnotatedMethod;
use Headzoo\Reflection\AnnotatedClass;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Reflection\AnnotatedMethod
 */
class AnnotatedMethodTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotatedMethod
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
        $this->fixture = $class->getMethod("getCounter");
    }

    /**
     * @covers ::getAnnotations
     */
    public function testGetAnnotations()
    {
        /** @var Headzoo\Method[] $annotations */
        $annotations = $this->fixture->getAnnotations();
        $this->assertCount(1, $annotations);
        $this->assertContainsOnlyInstancesOf(
            AbstractAnnotation::class,
            $annotations
        );
        $this->assertEquals(
            "internal",
            $annotations[0]->getValue()
        );
    }

    /**
     * @covers ::getAnnotation
     */
    public function testGetAnnotation()
    {
        $annotation = $this->fixture->getAnnotation(Headzoo\Method::class);
        $this->assertInstanceOf(
            Headzoo\Method::class,
            $annotation
        );

        $annotation = $this->fixture->getAnnotation(Headzoo\Property::class);
        $this->assertNull($annotation);
    }
}