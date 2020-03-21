<?php declare(strict_types = 1);

namespace Test\Resource\Attribute\Valid;

class CanAttribute
{
    private string $attribute = 'test';

    public function canAttribute(): string
    {
        return $this->attribute;
    }
}
