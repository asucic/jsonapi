<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Entity;

use ASucic\JsonApi\Schema;

class TestObjectSchema implements
    Schema\IdentityInterface,
    Schema\AttributeInterface,
    Schema\RelationshipInterface
{
    public function type(): string
    {
        return 'test';
    }

    public function attributes(): array
    {
        return [
            'title',
        ];
    }

    public function relationships(): array
    {
        return [
            'relation' => TestRelatedObjectSchema::class,
            'relations' => TestRelatedObjectSchema::class,
        ];
    }
}
