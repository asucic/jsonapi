<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Encoder;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\IdentityInterface;
use ReflectionException;

class IdentityEncoder
{
    private PropertyEncoder $propertyReader;

    public function __construct(PropertyEncoder $propertyReader)
    {
        $this->propertyReader = $propertyReader;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function encode(object $object, IdentityInterface $schema): array
    {
        return [
            'type' => $schema->type(),
            'id' => (string) $this->propertyReader->encode($object, 'id'),
        ];
    }
}
