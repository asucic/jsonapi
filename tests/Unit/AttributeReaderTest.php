<?php declare(strict_types = 1);

namespace Test\Unit;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Serializer\Reader\AttributeReader;
use ASucic\JsonApi\Serializer\Reader\PropertyReader;
use Generator;
use PHPUnit\Framework\TestCase;
use Test\Resource\Schema\Attribute\Sample;
use Test\Resource\Attribute\Invalid;
use Test\Resource\Attribute\Valid;

class AttributeReaderTest extends TestCase
{
    public static AttributeReader $reader;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$reader = new AttributeReader(new PropertyReader);
    }

    /** @test @dataProvider objectsWithValidAttributes */
    public function can_read_attributes_from_valid_object(object $object): void
    {
        $result = self::$reader->read($object, new Sample);
        $expected = [
            'attribute' => 'test',
        ];

        $this->assertSame($expected, $result);
    }

    /** @test @dataProvider objectsWithInvalidAttributes */
    public function can_throw_exception_for_invalid_object(object $object): void
    {
        $this->expectException(PropertyNotFoundException::class);

        self::$reader->read($object, new Sample);
    }

    /** @return Generator */
    public function objectsWithValidAttributes(): Generator
    {
        yield 'public attribute' => [new Valid\PublicAttribute];
        yield 'no method prefix' => [new Valid\NoMethodPrefixAttribute];
        yield 'get getter' => [new Valid\GetAttribute];
        yield 'has getter' => [new Valid\HasAttribute];
        yield 'can getter' => [new Valid\CanAttribute];
        yield 'is getter' => [new Valid\IsAttribute];
    }

    public function objectsWithInvalidAttributes(): Generator
    {
        yield 'private attribute' => [new Invalid\PrivateAttribute];
        yield 'protected attribute' => [new Invalid\ProtectedAttribute];
        yield 'getter with parameters' => [new Invalid\GetterWithParametersAttribute];
    }
}