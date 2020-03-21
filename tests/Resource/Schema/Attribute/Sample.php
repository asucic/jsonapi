<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Attribute;

use ASucic\JsonApi\Schema\AttributeInterface;

class Sample implements AttributeInterface
{
    public function attributes(): array
    {
        return [
            'attribute',
        ];
    }
}
