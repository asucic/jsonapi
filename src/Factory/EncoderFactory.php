<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Factory;

use ASucic\JsonApi\Serializer\Encoder\AttributeEncoder;
use ASucic\JsonApi\Serializer\Encoder\IdentityEncoder;
use ASucic\JsonApi\Serializer\Encoder\IncludedEncoder;
use ASucic\JsonApi\Serializer\Encoder\PropertyEncoder;
use ASucic\JsonApi\Serializer\Encoder\RelationshipEncoder;
use ASucic\JsonApi\Service\ArraySort;

class EncoderFactory
{
    public static function createPropertyEncoder(): PropertyEncoder
    {
        return new PropertyEncoder();
    }

    public static function createIdentityEncoder(): IdentityEncoder
    {
        return new IdentityEncoder(self::createPropertyEncoder());
    }

    public static function createAttributeEncoder(): AttributeEncoder
    {
        return new AttributeEncoder(self::createPropertyEncoder());
    }

    public static function createRelationshipEncoder(): RelationshipEncoder
    {
        return new RelationshipEncoder(
            self::createPropertyEncoder(),
            self::createIdentityEncoder(),
            self::createArraySort(),
        );
    }

    public static function createIncludedEncoder(): IncludedEncoder
    {
        return new IncludedEncoder(
            self::createPropertyEncoder(),
            self::createIdentityEncoder(),
            self::createAttributeEncoder(),
            self::createRelationshipEncoder(),
            self::createArraySort(),
        );
    }

    private static function createArraySort(): ArraySort
    {
        return new ArraySort();
    }
}
