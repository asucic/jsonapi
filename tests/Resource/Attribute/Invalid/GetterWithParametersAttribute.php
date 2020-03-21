<?php declare(strict_types = 1);

namespace Test\Resource\Attribute\Invalid;

class GetterWithParametersAttribute
{
    private string $attribute = 'test';

    public function getAttribute($invalidParameter): string
    {
        return $this->attribute;
    }
}
