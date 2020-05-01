<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Encoder;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\RelationshipInterface;
use ASucic\JsonApi\Service\ArraySort;
use ReflectionException;

class RelationshipEncoder
{
    private PropertyEncoder $propertyReader;
    private IdentityEncoder $identityReader;
    private ArraySort $sorter;

    public function __construct(
        PropertyEncoder $propertyReader,
        IdentityEncoder $identityReader,
        ArraySort $sorter
    ) {
        $this->propertyReader = $propertyReader;
        $this->identityReader = $identityReader;
        $this->sorter = $sorter;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function encode(object $object, RelationshipInterface $schema, array $included): array
    {
        $result = [];

        $included = $this->sorter->sortIncluded($included);

        foreach ($schema->relationships() as $relationship => $schemaName) {
            if (!array_key_exists($relationship, $included)) {
                continue;
            }

            $relatedSchema = new $schemaName;
            $relation = $this->propertyReader->encode($object, $relationship);

            if (!is_iterable($relation)) {
                $resource = $this->identityReader->encode($relation, $relatedSchema);

                $result[$relationship]['data'] = $resource;

                continue;
            }

            foreach ($relation as $item) {
                $resource = $this->identityReader->encode($item, $relatedSchema);

                $result[$relationship]['data'][] = $resource;
            }
        }

        return $result;
    }
}
