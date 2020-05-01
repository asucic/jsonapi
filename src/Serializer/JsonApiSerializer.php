<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema;
use ASucic\JsonApi\Serializer\Encoder;
use ReflectionException;

class JsonApiSerializer
{
    private Encoder\AttributeEncoder $attributeReader;
    private Encoder\IdentityEncoder $identityReader;
    private Encoder\RelationshipEncoder $relationshipReader;
    private Encoder\IncludedEncoder $includedReader;

    public function __construct(
        Encoder\AttributeEncoder $attributeReader,
        Encoder\IdentityEncoder $identityReader,
        Encoder\RelationshipEncoder $relationshipReader,
        Encoder\IncludedEncoder $includedReader
    ) {
        $this->attributeReader = $attributeReader;
        $this->identityReader = $identityReader;
        $this->relationshipReader = $relationshipReader;
        $this->includedReader = $includedReader;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function single(object $object, Schema\IdentityInterface $schema, array $included = []): array
    {
        $serialized = $this->serializeObject($object, $schema, $included);

        if (!empty($serialized['data']['relationships'])) {
            $serialized['included'] = array_values($this->includedReader->encode($object, $schema, $included));
        }

        return $serialized;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function list(iterable $objects, Schema\IdentityInterface $schema, array $included = []): array
    {
        $serializedList = [];
        $includedList = [];

        foreach ($objects as $object) {
            $serializedObject = $this->serializeObject($object, $schema, $included);
            $serializedObject = $serializedObject['data'];
            $identity = "$serializedObject[type]-$serializedObject[id]";
            $serializedList[$identity] = $serializedObject;

            if (!empty($serializedObject['relationships'])) {
                $includedList += $this->includedReader->encode($object, $schema, $included);
            }
        }

        return [
            'data' => array_values($serializedList),
            'included' => array_values($includedList),
        ];
    }

    private function serializeObject(object $object, Schema\IdentityInterface $schema, array $included = []): array
    {
        $serialized = [
            'data' => $this->identityReader->encode($object, $schema),
        ];

        if ($schema instanceof Schema\AttributeInterface) {
            $serialized['data']['attributes'] = $this->attributeReader->encode($object, $schema);
        }

        if (!$schema instanceof Schema\RelationshipInterface) {
            return $serialized;
        }

        $related = $this->relationshipReader->encode($object, $schema, $included);
        if (!empty($related)) {
            $serialized['data']['relationships'] = $related;
        }

        return $serialized;
    }
}

