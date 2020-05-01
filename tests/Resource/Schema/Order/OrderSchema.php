<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Order;

use ASucic\JsonApi\Schema;

class OrderSchema implements
    Schema\IdentityInterface,
    Schema\AttributeInterface,
    Schema\RelationshipInterface
{
    public function type(): string
    {
        return 'order';
    }

    public function attributes(): array
    {
        return [
            'address',
        ];
    }

    public function relationships(): array
    {
        return [
            'items' => ItemSchema::class,
        ];
    }
}
