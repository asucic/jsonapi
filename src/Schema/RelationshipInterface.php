<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Schema;

interface RelationshipInterface
{
    public function relationships(): array;
}
