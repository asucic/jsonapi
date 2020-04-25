<?php declare(strict_types = 1);

namespace Test\Resource\Entity;

class Embedded1
{
    public int $id;
    public Embedded2 $embedded2;

    public function __construct(int $id, Embedded2 $embedded2)
    {
        $this->id = $id;
        $this->embedded2 = $embedded2;
    }
}
