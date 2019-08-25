<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Exceptions;

use Exception;

class PropertyAccessNotFound extends Exception
{
    public function __construct(string $property)
    {
        $message = "No public property or methods for '$property' found";

        parent::__construct($message, 500, null);
    }
}
