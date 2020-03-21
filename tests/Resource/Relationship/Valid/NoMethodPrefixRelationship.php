<?php declare(strict_types = 1);

namespace Test\Resource\Relationship\Valid;

class NoMethodPrefixRelationship
{
    private RelatedObject $related;
    private array $multipleObjects;

    public function __construct()
    {
        $this->related = new RelatedObject;
        $this->multipleObjects = [
            new RelatedObject,
        ];
    }

    public function related(): RelatedObject
    {
        return $this->related;
    }

    public function multipleObjects(): array
    {
        return $this->multipleObjects;
    }
}