<?php declare(strict_types = 1);

namespace Test\Resource\Attribute\Valid;

class NoMethodPrefixAttribute
{
    private string $attribute = 'test';

    public function attribute(): string
    {
        return $this->attribute;
    }
}
