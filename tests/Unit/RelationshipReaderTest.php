<?php declare(strict_types = 1);

namespace Test\Unit;

use ASucic\JsonApi\Serializer\Reader;
use Generator;
use PHPUnit\Framework\TestCase;
use Test\Resource\Relationship\Valid;
use Test\Resource\Schema\Relationship\MainSchema;

class RelationshipReaderTest extends TestCase
{
    public static Reader\RelationshipReader $reader;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $propertyReader = new Reader\PropertyReader;
        self::$reader = new Reader\RelationshipReader(
            new Reader\IdentityReader($propertyReader),
            $propertyReader,
        );
    }

    /** @test @dataProvider objectsWithValidRelationships */
    public function can_read_relationships_from_valid_object(object $object): void
    {
        $result = self::$reader->read($object, new MainSchema);
        $expected = [
            'relationships' => [
                'related' => [
                    'data' => [
                        'type' => 'relatedObject',
                        'id' => 1,
                    ]
                ],
                'multipleObjects' => [
                    'data' => [
                        [
                            'type' => 'relatedObject',
                            'id' => 1,
                        ]
                    ]
                ],
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /** @return Generator */
    public function objectsWithValidRelationships(): Generator
    {
        yield 'public relationship' => [new Valid\PublicRelationship];
        yield 'no method prefix' => [new Valid\NoMethodPrefixRelationship];
        yield 'get getter' => [new Valid\GetRelationship];
    }
}