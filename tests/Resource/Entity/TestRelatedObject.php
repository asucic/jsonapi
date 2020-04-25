<?php declare(strict_types = 1);

namespace Test\Resource\Entity;

class TestRelatedObject
{
    public int $id;
    public string $title;
    public ?TestRelatedObject $embeddedRelation;

    public function __construct(int $id, string $title, ?TestRelatedObject $embeddedRelation = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->embeddedRelation = $embeddedRelation;
    }
}
