<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Encoder;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\AttributeInterface;
use ASucic\JsonApi\Schema\RelationshipInterface;
use ASucic\JsonApi\Service\ArraySort;
use ReflectionException;

class IncludedEncoder
{
    private PropertyEncoder $propertyReader;
    private IdentityEncoder $identityReader;
    private AttributeEncoder $attributeReader;
    private RelationshipEncoder $relationshipReader;
    private ArraySort $sorter;

    public function __construct(
        PropertyEncoder $propertyReader,
        IdentityEncoder $identityReader,
        AttributeEncoder $attributeReader,
        RelationshipEncoder $relationshipReader,
        ArraySort $sorter
    ) {
        $this->propertyReader = $propertyReader;
        $this->identityReader = $identityReader;
        $this->attributeReader = $attributeReader;
        $this->relationshipReader = $relationshipReader;
        $this->sorter = $sorter;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function encode(object $object, RelationshipInterface $schema, array $included): array
    {
        $included = $this->sorter->sortIncluded($included);

        return $this->process($object, $schema, $included);
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    private function process(object $object, RelationshipInterface $schema, array $included): array
    {
        $result = [];

        foreach ($schema->relationships() as $relationship => $schemaName) {
            if (!array_key_exists($relationship, $included)) {
                continue;
            }

            $relatedSchema = new $schemaName;
            $relation = $this->propertyReader->encode($object, $relationship);

            if (!is_iterable($relation)) {
                $relation = [$relation];
            }

            foreach ($relation as $item) {
                $identity = $this->identityReader->encode($item, $relatedSchema);
                $id = "$relationship-$identity[id]";

                $result[$id] = $identity;

                if ($relatedSchema instanceof AttributeInterface) {
                    $attributes = $this->attributeReader->encode($item, $relatedSchema);
                    $result[$id]['attributes'] = $attributes;
                }

                if ($relatedSchema instanceof RelationshipInterface) {
                    $relationships = $this->relationshipReader
                        ->encode($item, $relatedSchema, $included[$relationship] ?? [])
                    ;

                    $result[$id]['relationships'] = $relationships;

                    if (!empty($included[$relationship])) {
                        $result += $this->process($item, $relatedSchema, $included[$relationship]);
                    }
                }
            }
        }

        return $result;
    }
}
