<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Entity;

use ASucic\JsonApi\Schema;

class Embedded1Schema implements
    Schema\IdentityInterface,
    Schema\RelationshipInterface
{
    public function type(): string
    {
        return 'embedded1';
    }

    public function relationships(): array
    {
        return [
            'embedded2' => Embedded2Schema::class,
        ];
    }
}
