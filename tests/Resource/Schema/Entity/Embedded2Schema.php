<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Entity;

use ASucic\JsonApi\Schema;

class Embedded2Schema implements
    Schema\IdentityInterface,
    Schema\RelationshipInterface
{
    public function type(): string
    {
        return 'embedded2';
    }

    public function relationships(): array
    {
        return [
            'embedded3' => Embedded3Schema::class,
        ];
    }
}
