<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Entity;

use ASucic\JsonApi\Schema;

class TestRelatedObjectSchema implements Schema\IdentityInterface, Schema\AttributeInterface
{
    public function type(): string
    {
        return 'related';
    }

    public function attributes(): array
    {
        return [
            'title',
        ];
    }
}
