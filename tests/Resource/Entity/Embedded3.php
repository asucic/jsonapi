<?php declare(strict_types = 1);

namespace Test\Resource\Entity;

class Embedded3
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
