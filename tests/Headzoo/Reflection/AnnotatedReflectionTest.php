<?php
namespace Headzoo\Reflection\Tests;

use Doctrine\Common\Annotations\Reader;
use Headzoo\Reflection\AnnotatedReflection;
use Headzoo\Reflection\Annotation\Headzoo\Property;
use Headzoo\Reflection\Annotation\Headzoo\TestClass;
use Headzoo\Reflection\Annotation\Headzoo\TestPerson;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Headzoo\Reflection\AnnotatedReflection
 */
class AnnotatedReflectionTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::registerAnnotation
     * @covers ::registerAnnotations
     */
    public function testRegisterAnnotation()
    {
        $this->assertTrue(
            AnnotatedReflection::registerAnnotation(Property::class)
        );
        $this->assertTrue(
            AnnotatedReflection::registerAnnotations([
                TestClass::class,
                TestPerson::class,
                Property::class
            ])
        );
        $this->assertEquals(
            [
                Property::class,
                TestClass::class,
                TestPerson::class
            ],
            AnnotatedReflection::getRegisteredAnnotations()
        );
    }

    /**
     * @covers ::reader
     */
    public function testReader()
    {
        $this->assertInstanceOf(
            Reader::class,
            AnnotatedReflection::reader()
        );
        $this->assertSame(
            AnnotatedReflection::reader(),
            AnnotatedReflection::reader()
        );
    }
}