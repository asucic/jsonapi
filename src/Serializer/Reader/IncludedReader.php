<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Schema\RelationshipInterface;
use ReflectionClass;
use ReflectionException;

class IncludedReader
{
    /** @throws ReflectionException */
    public function read(object $object, RelationshipInterface $schema, array $included): array
    {
        $class = new ReflectionClass($object);

        $attributes = [];
        foreach ($included as $relation) {
        }

        return $attributes;
    }
}
