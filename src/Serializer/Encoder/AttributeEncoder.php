<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Encoder;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\AttributeInterface;
use ReflectionException;

class AttributeEncoder
{
    private PropertyEncoder $propertyReader;

    public function __construct(PropertyEncoder $propertyReader)
    {
        $this->propertyReader = $propertyReader;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function encode(object $object, AttributeInterface $schema): array
    {
        $attributes = [];
        foreach ($schema->attributes() as $attribute) {
            $attributes[$attribute] = $this->propertyReader->encode($object, $attribute);
        }

        return $attributes;
    }
}
