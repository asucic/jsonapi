<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Test\Resources\Objects;

class TestClosedObject
{
    private $id = 1;
    private $name = 'Test';
    private $test = true;
    private $relationships;

    private function getId(): int
    {
        return $this->id;
    }

    private function setId(int $id): void
    {
        $this->id = $id;
    }

    private function getName(): string
    {
        return $this->name;
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    private function isTest(): bool
    {
        return $this->test;
    }

    private function setTest(bool $test): void
    {
        $this->test = $test;
    }

    private function getRelationships()
    {
        return $this->relationships;
    }

    private function setRelationships($relationships): void
    {
        $this->relationships = $relationships;
    }
}