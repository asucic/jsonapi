<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Exception\Serializer\Reader;

use Exception;

class PropertyNotFoundException extends Exception
{
    public function __construct(string $class, string $property)
    {
        $message = sprintf(
            'Could not find access to property "%1$s" of class "%2$s".' .
            'Property should be either public or have declared getter methods: ' .
            '"get%3$s", "is%3$s", "has%3$s", "can%3$s". If you are using ' .
            'one of the getter methods, they can not have parameters.',
            $property,
            $class,
            ucfirst($property)
        );

        parent::__construct($message, 400);
    }
}
