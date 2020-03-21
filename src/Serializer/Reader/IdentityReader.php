<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\IdentityInterface;
use ReflectionException;

class IdentityReader
{
    private PropertyReader $propertyReader;

    public function __construct(PropertyReader $propertyReader)
    {
        $this->propertyReader = $propertyReader;
    }

    /** @throws PropertyNotFoundException|ReflectionException */
    public function read(object $object, IdentityInterface $schema): array
    {
        return [
            'type' => $schema->type(),
            'id' => $this->propertyReader->read($object, 'id'),
        ];
    }
}
