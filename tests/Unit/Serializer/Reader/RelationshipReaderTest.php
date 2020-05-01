<?php declare(strict_types = 1);

namespace Test\Unit\Serializer\Reader;

use ASucic\JsonApi\Factory\EncoderFactory;
use Generator;
use PHPUnit\Framework\TestCase;
use Test\Resource\Relationship\Valid;
use Test\Resource\Schema\Relationship\MainSchema;

class RelationshipReaderTest extends TestCase
{
    /** @test @dataProvider objectsWithValidRelationships */
    public function can_read_relationships_from_valid_object(object $object): void
    {
        $relationships = EncoderFactory::createRelationshipEncoder()
            ->encode($object, new MainSchema, ['related', 'multipleObjects'])
        ;

        $expected = [
            'related' => [
                'data' => [
                    'type' => 'relatedObject',
                    'id' => '1',
                ]
            ],
            'multipleObjects' => [
                'data' => [
                    [
                        'type' => 'relatedObject',
                        'id' => '1',
                    ]
                ]
            ],
        ];

        $this->assertSame($expected, $relationships);
    }

    /** @return Generator */
    public function objectsWithValidRelationships(): Generator
    {
        yield 'public relationship' => [new Valid\PublicRelationship];
        yield 'no method prefix' => [new Valid\NoMethodPrefixRelationship];
        yield 'get getter' => [new Valid\GetRelationship];
    }
}