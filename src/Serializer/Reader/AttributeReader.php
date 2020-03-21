<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\AttributeInterface;
use ReflectionException;

class AttributeReader
{
    private PropertyReader $propertyReader;

    public function __construct(PropertyReader $propertyReader)
    {
        $this->propertyReader = $propertyReader;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function read(object $object, AttributeInterface $schema): array
    {
        $attributes = [];
        foreach ($schema->attributes() as $attribute) {
            $attributes[$attribute] = $this->propertyReader->read($object, $attribute);
        }

        return $attributes;
    }
}
