<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer;

use ASucic\JsonApi\Exception\Serializer\Reader\InvalidSchemaException;
use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema;
use ASucic\JsonApi\Serializer\Reader;
use ReflectionException;

class JsonApiSerializer
{
    private Reader\AttributeReader $attributeReader;
    private Reader\IdentityReader $identityReader;
    private Reader\RelationshipReader $relationshipReader;
    private Reader\IncludedReader $includedReader;

    public function __construct(
        Reader\AttributeReader $attributeReader,
        Reader\IdentityReader $identityReader,
        Reader\RelationshipReader $relationshipReader,
        Reader\IncludedReader $includedReader
    ) {
        $this->attributeReader = $attributeReader;
        $this->identityReader = $identityReader;
        $this->relationshipReader = $relationshipReader;
        $this->includedReader = $includedReader;
    }

    /** @throws InvalidSchemaException|PropertyNotFoundException|ReflectionException */
    public function single(object $object, Schema\IdentityInterface $schema, array $included = []): array
    {
        $serialized = $this->serializeObject($object, $schema, $included);

        if (!empty($serialized['data']['relationships'])) {
            $serialized['included'] = array_values($this->includedReader->read($object, $schema, $included));
        }

        return $serialized;
    }

    public function list(iterable $objects, Schema\IdentityInterface $schema, array $included = []): array
    {
        $serializedList = [];
        $includedList = [];

        foreach ($objects as $object) {
            $serializedObject = $this->single($object, $schema, $included);
            $identity = "$serializedObject[data][type]-$serializedObject[data][id]";
            $serializedList[$identity] = $serializedObject;

            if (!empty($serialized['data']['relationships'])) {
                $includedList += array_values($this->includedReader->read($object, $schema, $included));
            }
        }

        $serializedList = array_values($serializedList);
        $serialized['included'] = array_values($includedList);

        return $serializedList;
    }

    private function serializeObject(object $object, Schema\IdentityInterface $schema, array $included = []): array
    {
        $serialized = [
            'data' => $this->identityReader->read($object, $schema),
        ];

        if ($schema instanceof Schema\AttributeInterface) {
            $serialized['data']['attributes'] = $this->attributeReader->read($object, $schema);
        }

        if (!$schema instanceof Schema\RelationshipInterface) {
            return $serialized;
        }

        $related = $this->relationshipReader->read($object, $schema, $included);
        if (!empty($related)) {
            $serialized['data']['relationships'] = $related;
            $serialized['included'] = array_values($this->includedReader->read($object, $schema, $included));
        }

        return $serialized;
    }
}

