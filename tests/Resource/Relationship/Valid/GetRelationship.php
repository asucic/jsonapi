<?php declare(strict_types = 1);

namespace Test\Resource\Relationship\Valid;

class GetRelationship
{
    public int $id = 1;
    private RelatedObject $related;
    private array $multipleObjects;

    public function __construct()
    {
        $this->related = new RelatedObject;
        $this->multipleObjects = [
            new RelatedObject,
        ];
    }

    public function getRelated(): RelatedObject
    {
        return $this->related;
    }

    public function getMultipleObjects(): array
    {
        return $this->multipleObjects;
    }
}