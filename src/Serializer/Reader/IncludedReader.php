<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Exception\Serializer\Reader\InvalidSchemaException;
use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\AttributeInterface;
use ASucic\JsonApi\Schema\IdentityInterface;
use ASucic\JsonApi\Schema\RelationshipInterface;
use ASucic\JsonApi\Service\ArraySort;
use ReflectionException;
use Traversable;

final class IncludedReader
{
    private PropertyReader $propertyReader;
    private IdentityReader $identityReader;
    private AttributeReader $attributeReader;
    private RelationshipReader $relationshipReader;
    private ArraySort $sorter;

    public function __construct(
        PropertyReader $propertyReader,
        IdentityReader $identityReader,
        AttributeReader $attributeReader,
        RelationshipReader $relationshipReader,
        ArraySort $sorter
    ) {
        $this->propertyReader = $propertyReader;
        $this->identityReader = $identityReader;
        $this->attributeReader = $attributeReader;
        $this->relationshipReader = $relationshipReader;
        $this->sorter = $sorter;
    }

    /** @throws PropertyNotFoundException|ReflectionException|InvalidSchemaException */
    public function read(object $object, RelationshipInterface $schema, array $included): array
    {
        $included = $this->sorter->sortIncluded($included);

        return $this->process($object, $schema, $included);
    }

    /** @throws PropertyNotFoundException|ReflectionException|InvalidSchemaException */
    private function process(object $object, RelationshipInterface $schema, array $included): array
    {
        $result = [];

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
                $relation = [$relation];
            }

            foreach ($relation as $item) {
                $identity = $this->identityReader->read($item, $relatedSchema);
                $id = "$relationship-$identity[id]";

                $result[$id] = $identity;

                if ($relatedSchema instanceof AttributeInterface) {
                    $attributes = $this->attributeReader->read($item, $relatedSchema);
                    $result[$id]['attributes'] = $attributes;
                }

                if ($relatedSchema instanceof RelationshipInterface) {
                    $relationships = $this->relationshipReader
                        ->read($item, $relatedSchema, $included[$relationship] ?? [])
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
