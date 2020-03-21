<?php declare(strict_types = 1);

namespace Test\Resource\Attribute\Valid;

class GetAttribute
{
    private string $attribute = 'test';

    public function getAttribute(): string
    {
        return $this->attribute;
    }
}
