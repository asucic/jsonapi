<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Exception\Serializer\Reader;

use ASucic\JsonApi\Schema\IdentityInterface;
use Exception;

class InvalidSchemaException extends Exception
{
    public function __construct(string $class)
    {
        parent::__construct("$class does not implement " . IdentityInterface::class , 400);
    }
}
