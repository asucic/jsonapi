<?php declare(strict_types = 1);

namespace Test\Unit\Serializer;

use ASucic\JsonApi\Serializer\JsonApiSerializer;
use ASucic\JsonApi\Serializer\Reader;
use ASucic\JsonApi\Service\ArraySort;
use PHPUnit\Framework\TestCase;
use Test\Resource\Entity\Embedded1;
use Test\Resource\Entity\Embedded2;
use Test\Resource\Entity\Embedded3;
use Test\Resource\Entity\TestObject;
use Test\Resource\Entity\TestRelatedObject;
use Test\Resource\Schema\Entity\Embedded1Schema;
use Test\Resource\Schema\Entity\TestObjectSchema;

class JsonApiSerializerListTest extends TestCase
{
    public static JsonApiSerializer $serializer;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $sorter = new ArraySort();
        $propertyReader = new Reader\PropertyReader();
        $attributeReader = new Reader\AttributeReader($propertyReader);
        $identityReader = new Reader\IdentityReader($propertyReader);
        $relationshipReader = new Reader\RelationshipReader($identityReader, $propertyReader, $sorter);
        $includedReader = new Reader\IncludedReader(
            $propertyReader,
            $identityReader,
            $attributeReader,
            $relationshipReader,
            $sorter,
        );

        self::$serializer = new JsonApiSerializer(
            $attributeReader,
            $identityReader,
            $relationshipReader,
            $includedReader,
        );
    }

    /** @ test */
    public function can_serialize_object(): void
    {
        $object = new TestObject(1, 'test', new TestRelatedObject(1, 'test1'), [
            new TestRelatedObject(2, 'test2'),
            new TestRelatedObject(3, 'test3'),
        ]);

        $result = self::$serializer->single($object, new TestObjectSchema, ['relation', 'relations']);
        $expected = [
            'data' => [
                'type' => 'test',
                'id' => '1',
                'attributes' => [
                    'title' => 'test',
                ],
                'relationships' => [
                    'relation' => [
                        'data' => [
                            'type' => 'related',
                            'id' => '1',
                        ],
                    ],
                    'relations' => [
                        'data' => [
                            [
                                'type' => 'related',
                                'id' => '2',
                            ],
                            [
                                'type' => 'related',
                                'id' => '3',
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'related',
                    'id' => '1',
                    'attributes' => [
                        'title' => 'test1',
                    ],
                ],
                [
                    'type' => 'related',
                    'id' => '2',
                    'attributes' => [
                        'title' => 'test2',
                    ],
                ],
                [
                    'type' => 'related',
                    'id' => '3',
                    'attributes' => [
                        'title' => 'test3',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /** @ test */
    public function can_serialize_object_with_embedded_relationships(): void
    {
        $embeddedRelationship = new Embedded3(3);
        $relationship = new Embedded2(2, $embeddedRelationship);
        $object = new Embedded1(1, $relationship);

        $result = self::$serializer->single($object, new Embedded1Schema, [
            'embedded2',
            'embedded2.embedded3',
        ]);

        $expected = [
            'data' => [
                'type' => 'embedded1',
                'id' => '1',
                'relationships' => [
                    'embedded2' => [
                        'data' => [
                            'type' => 'embedded2',
                            'id' => '2',
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'embedded2',
                    'id' => '2',
                    'relationships' => [
                        'embedded3' => [
                            'data' => [
                                'type' => 'embedded3',
                                'id' => '3',
                            ],
                        ],
                    ],
                ],
                [
                    'type' => 'embedded3',
                    'id' => '3',
                ],
            ],
        ];

        $this->assertSame($expected, $result);
    }
}