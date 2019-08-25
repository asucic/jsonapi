<?php declare(strict_types = 1);

namespace ASucic\JsonApi;

interface HydratorInterface
{
    public function hydrate(string $message): object;
}
