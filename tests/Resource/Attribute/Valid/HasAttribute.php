<?php declare(strict_types = 1);

namespace Test\Resource\Attribute\Valid;

class HasAttribute
{
    private string $attribute = 'test';

    public function hasAttribute(): string
    {
        return $this->attribute;
    }
}
