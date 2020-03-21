<?php declare(strict_types = 1);

namespace Test\Resource\Schema\Relationship;

use ASucic\JsonApi\Schema\IdentityInterface;

class RelatedSchema implements IdentityInterface
{
    public function type(): string
    {
        return 'relatedObject';
    }
}
