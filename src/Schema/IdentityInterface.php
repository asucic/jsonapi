<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Schema;

interface IdentityInterface
{
    public function type(): string;
}
