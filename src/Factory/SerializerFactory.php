<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Factory;

use ASucic\JsonApi\Serializer\JsonApiSerializer;

class SerializerFactory
{
    public static function createJsonApiSerializer(): JsonApiSerializer
    {
        return new JsonApiSerializer(
            EncoderFactory::createAttributeEncoder(),
            EncoderFactory::createIdentityEncoder(),
            EncoderFactory::createRelationshipEncoder(),
            EncoderFactory::createIncludedEncoder(),
        );
    }
}
