<?php declare(strict_types = 1);

namespace Test\Resource\Entity\Order;

class Item
{
    public int $id;
    public int $quantity;
    public int $price;

    public function __construct(int $id, int $quantity, int $price, string $name)
    {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->hiddenName = $name;
    }

    public function getName(): string
    {
        return $this->hiddenName;
    }
}
