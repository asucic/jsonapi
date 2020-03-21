<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Relationship;

use ASucic\JsonApi\Schema\RelationshipInterface;

class MainSchema implements RelationshipInterface
{
    public function relationships(): array
    {
        return [
            'related' => RelatedSchema::class,
            'multipleObjects' => RelatedSchema::class,
        ];
    }
}
