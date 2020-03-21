<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer;

use ASucic\JsonApi\Schema;
use ASucic\JsonApi\Serializer\Reader;

class JsonApiSerializer
{
    private Reader\AttributeReader $attributeReader;
    private Reader\IdentityReader $identityReader;
    private Reader\RelationshipReader $relationshipReader;

    public function __construct(
        Reader\AttributeReader $attributeReader,
        Reader\IdentityReader $identityReader,
        Reader\RelationshipReader $relationshipReader
    ) {
        $this->attributeReader = $attributeReader;
        $this->identityReader = $identityReader;
        $this->relationshipReader = $relationshipReader;
    }

    public function single(object $object, Schema\IdentityInterface $schema, array $included): array
    {
        $message = [
            'data' => $this->identityReader->read($object, $schema),
        ];

        if ($schema instanceof Schema\AttributeInterface) {
            $message['data']['attributes'] = $this->attributeReader->read($object, $schema);
        }

        if ($schema instanceof Schema\RelationshipInterface) {
            $message['data']['relationships'] = $this->relationshipReader->read($object, $schema);
            $message['data']['included'] = $this->included($schema, $included);
        }

        return $message;
    }

    private function included(Schema\RelationshipInterface $schema, array $included): array
    {
        return [];
    }
}

