<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Entity;

use ASucic\JsonApi\Schema;

class Embedded3Schema implements Schema\IdentityInterface
{
    public function type(): string
    {
        return 'embedded3';
    }
}
