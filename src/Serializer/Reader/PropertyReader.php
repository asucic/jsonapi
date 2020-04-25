<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Serializer\Reader;

use ASucic\JsonApi\Exception\Serializer\Reader\PropertyNotFoundException;
use ReflectionClass;
use ReflectionException;

final class PropertyReader
{
    private const METHOD_PREFIXES = [
        '',
        'get',
        'is',
        'has',
        'can',
    ];

    /** @throws PropertyNotFoundException|ReflectionException */
    public function read(object $object, string $attribute)
    {
        $reflection = new ReflectionClass($object);

        try {
            if ($reflection->getProperty($attribute)->isPublic()) {
                return $reflection->getProperty($attribute)->getValue($object);
            }
        } catch (ReflectionException $exception) {
            // property does not exist, continue
        }

        foreach (self::METHOD_PREFIXES as $prefix) {
            $method = empty($prefix) ? $attribute : $prefix . ucfirst($attribute);

            try {
                if (
                    $reflection->getMethod($method)->isPublic()
                    &&
                    empty($reflection->getMethod($method)->getParameters())
                ) {
                    return $reflection->getMethod($method)->invoke($object);
                }
            } catch (ReflectionException $exception) {
                // method does not exits, continue
            }
        }

        throw new PropertyNotFoundException(get_class($object), $attribute);
    }
}
