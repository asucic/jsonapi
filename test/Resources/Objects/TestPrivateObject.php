<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Test\Resources\Objects;

class TestPrivateObject
{
    private $id = 1;
    private $name = 'Test';
    private $test = true;
    private $relationships;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isTest(): bool
    {
        return $this->test;
    }

    public function setTest(bool $test): void
    {
        $this->test = $test;
    }

    public function getRelationships()
    {
        return $this->relationships;
    }

    public function setRelationships($relationships): void
    {
        $this->relationships = $relationships;
    }
}