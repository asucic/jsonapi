<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Exception\Serializer\Reader\InvalidSchemaException;
use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\IdentityInterface;
use ASucic\JsonApi\Schema\RelationshipInterface;
use ASucic\JsonApi\Service\ArraySort;
use ReflectionException;

final class RelationshipReader
{
    private IdentityReader $identityReader;
    private PropertyReader $propertyReader;
    private ArraySort $sorter;

    public function __construct(
        IdentityReader $identityReader,
        PropertyReader $propertyReader,
        ArraySort $sorter
    ) {
        $this->identityReader = $identityReader;
        $this->propertyReader = $propertyReader;
        $this->sorter = $sorter;
    }

    /** @throws PropertyNotFoundException|ReflectionException|InvalidSchemaException */
    public function read(object $object, RelationshipInterface $schema, array $included): array
    {
        $result = [];

        $included = $this->sorter->sortIncluded($included);

        foreach ($schema->relationships() as $relationship => $schemaName) {
            if (!array_key_exists($relationship, $included)) {
                continue;
            }

            $relatedSchema = new $schemaName;

            if (!$relatedSchema instanceof IdentityInterface) {
                throw new InvalidSchemaException(get_class($relatedSchema));
            }

            $relation = $this->propertyReader->read($object, $relationship);

            if (!is_iterable($relation)) {
                $resource = $this->identityReader->read($relation, $relatedSchema);

                $result[$relationship]['data'] = $resource;

                continue;
            }

            foreach ($relation as $item) {
                $resource = $this->identityReader->read($item, $relatedSchema);

                $result[$relationship]['data'][] = $resource;
            }
        }

        return $result;
    }
}
