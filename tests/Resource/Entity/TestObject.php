<?php declare(strict_types = 1);

namespace Test\Resource\Entity;

class TestObject
{
    public int $id;
    public string $title;
    public TestRelatedObject $relation;
    public array $relations;

    public function __construct(int $id, string $title, TestRelatedObject $relation, array $relations)
    {
        $this->id = $id;
        $this->title = $title;
        $this->relation = $relation;
        $this->relations = $relations;
    }
}
