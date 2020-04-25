<?php declare(strict_types = 1);

namespace Test\Resource\Entity;

class Embedded2
{
    public int $id;
    public Embedded3 $embedded3;

    public function __construct(int $id, Embedded3 $embedded3)
    {
        $this->id = $id;
        $this->embedded3 = $embedded3;
    }
}
