<?php declare(strict_types = 1);

namespace ASucic\JsonApi;

interface SerializerInterface
{
    public function serialize(object $object): string;
}
