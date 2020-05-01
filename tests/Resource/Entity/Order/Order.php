<?php declare(strict_types = 1);

namespace Test\Resource\Entity\Order;

class Order
{
    public int $id;
    public string $address;
    public array $items;

    public function __construct(int $id, string $address)
    {
        $this->id = $id;
        $this->address = $address;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }
}
