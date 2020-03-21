<?php declare(strict_types = 1);

namespace Test\Resource\Attribute\Valid;

class IsAttribute
{
    private string $attribute = 'test';

    public function isAttribute(): string
    {
        return $this->attribute;
    }
}
