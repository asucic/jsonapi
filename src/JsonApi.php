<?php declare(strict_types = 1);

namespace ASucic\JsonApi;

class JsonApi implements SerializerInterface, HydratorInterface
{
    public function hydrate(string $message): object
    {
    }

    public function serialize(object $object): string
    {
    }
}
