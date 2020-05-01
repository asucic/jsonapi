<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Order;

use ASucic\JsonApi\Schema;

class ItemSchema implements Schema\IdentityInterface, Schema\AttributeInterface
{
    public function type(): string
    {
        return 'order-item';
    }

    public function attributes(): array
    {
        return [
            'quantity',
            'price',
            'name',
        ];
    }
}
