<?php declare(strict_types = 1);

namespace Test\Resource\Relationship\Valid;

class PublicRelationship
{
    public int $id = 1;
    public RelatedObject $related;
    public array $multipleObjects;

    public function __construct()
    {
        $this->related = new RelatedObject;
        $this->multipleObjects = [
            new RelatedObject,
        ];
    }
}
