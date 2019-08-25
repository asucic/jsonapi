<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Schemas;

interface SchemaInterface
{
    public function getId(): string;
    public function getAttributes(): array;
    public function getRelationships(): array;
}
