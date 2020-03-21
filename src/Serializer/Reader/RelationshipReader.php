<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Exception\Serializer\Reader\InvalidSchemaException;
use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ASucic\JsonApi\Schema\RelationshipInterface;
use ReflectionException;

class RelationshipReader
{
    private IdentityReader $identityReader;
    private PropertyReader $propertyReader;

    public function __construct(IdentityReader $identityReader, PropertyReader $propertyReader)
    {
        $this->identityReader = $identityReader;
        $this->propertyReader = $propertyReader;
    }

    /** @throws PropertyNotFoundException|ReflectionException|InvalidSchemaException */
    public function read(object $object, RelationshipInterface $schema): array
    {
        $relationships = [];
        foreach ($schema->relationships() as $relationship => $schemaName) {
            $resource = $this->propertyReader->read($object, $relationship);

            if (!is_iterable($resource)) {
                $relationships['relationships'][$relationship]['data'] =
                    $this->identityReader->read($resource, new $schemaName)
                ;

                continue;
            }

            foreach ($resource as $item) {
                $relationships['relationships'][$relationship]['data'][] =
                    $this->identityReader->read($item, new $schemaName)
                ;
            }
        }

        return $relationships;
    }
}
