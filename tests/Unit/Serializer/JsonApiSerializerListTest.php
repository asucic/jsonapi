<?php declare(strict_types = 1);

namespace Test\Unit\Serializer;

use ASucic\JsonApi\Factory\SerializerFactory;
use PHPUnit\Framework\TestCase;
use Test\Resource\Entity\Order\Item;
use Test\Resource\Entity\Order\Order;
use Test\Resource\Schema\Entity\Embedded1Schema;
use Test\Resource\Schema\Order\OrderSchema;

class JsonApiSerializerListTest extends TestCase
{
    /** @test */
    public function can_serialize_list_of_objects(): void
    {
        $firstOrder = new Order(1, 'Test street');
        $firstOrder->addItem(new Item(1, 10, 100, 'first item'));
        $firstOrder->addItem(new Item(2, 4, 75, 'second item'));

        $secondOrder = new Order(2, 'Test street 2');
        $secondOrder->addItem(new Item(3, 2, 22, 'third item'));
        $secondOrder->addItem(new Item(4, 5, 66, 'fourth item'));

        $orders = [$firstOrder, $secondOrder];

        $result = SerializerFactory::createJsonApiSerializer()
            ->list($orders, new OrderSchema(), ['items'])
        ;

        $expected = [
            'data' => [
                [
                    'type' => 'order',
                    'id' => '1',
                    'attributes' => [
                        'address' => 'Test street',
                    ],
                    'relationships' => [
                        'items' => [
                            'data' => [
                                [
                                    'type' => 'order-item',
                                    'id' => '1',
                                ],
                                [
                                    'type' => 'order-item',
                                    'id' => '2',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => 'order',
                    'id' => '2',
                    'attributes' => [
                        'address' => 'Test street 2',
                    ],
                    'relationships' => [
                        'items' => [
                            'data' => [
                                [
                                    'type' => 'order-item',
                                    'id' => '3',
                                ],
                                [
                                    'type' => 'order-item',
                                    'id' => '4',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'order-item',
                    'id' => '1',
                    'attributes' => [
                        'quantity' => 10,
                        'price' => 100,
                        'name' => 'first item',
                    ],
                ],
                [
                    'type' => 'order-item',
                    'id' => '2',
                    'attributes' => [
                        'quantity' => 4,
                        'price' => 75,
                        'name' => 'second item',
                    ],
                ],
                [
                    'type' => 'order-item',
                    'id' => '3',
                    'attributes' => [
                        'quantity' => 2,
                        'price' => 22,
                        'name' => 'third item',
                    ],
                ],
                [
                    'type' => 'order-item',
                    'id' => '4',
                    'attributes' => [
                        'quantity' => 5,
                        'price' => 66,
                        'name' => 'fourth item',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function can_serialize_object_with_shared_relationships(): void
    {
        $firstItem = new Item(1, 100, 100, 'first item');
        $secondItem = new Item(2, 200, 200, 'second item');

        $firstOrder = new Order(1, 'Test street');
        $firstOrder->addItem($firstItem);
        $firstOrder->addItem($secondItem);

        $secondOrder = new Order(2, 'Test street 2');
        $secondOrder->addItem($firstItem);
        $secondOrder->addItem($secondItem);

        $orders = [$firstOrder, $secondOrder];

        $result = SerializerFactory::createJsonApiSerializer()
            ->list($orders, new OrderSchema(), ['items'])
        ;

        $expected = [
            'data' => [
                [
                    'type' => 'order',
                    'id' => '1',
                    'attributes' => [
                        'address' => 'Test street',
                    ],
                    'relationships' => [
                        'items' => [
                            'data' => [
                                [
                                    'type' => 'order-item',
                                    'id' => '1',
                                ],
                                [
                                    'type' => 'order-item',
                                    'id' => '2',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => 'order',
                    'id' => '2',
                    'attributes' => [
                        'address' => 'Test street 2',
                    ],
                    'relationships' => [
                        'items' => [
                            'data' => [
                                [
                                    'type' => 'order-item',
                                    'id' => '1',
                                ],
                                [
                                    'type' => 'order-item',
                                    'id' => '2',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'order-item',
                    'id' => '1',
                    'attributes' => [
                        'quantity' => 100,
                        'price' => 100,
                        'name' => 'first item',
                    ],
                ],
                [
                    'type' => 'order-item',
                    'id' => '2',
                    'attributes' => [
                        'quantity' => 200,
                        'price' => 200,
                        'name' => 'second item',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $result);
    }
}