<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Test\Unit\Schemas;

use ASucic\JsonApi\Exceptions\PropertyAccessNotFound;
use ASucic\JsonApi\Schemas\ObjectSchema;
use ASucic\JsonApi\Test\Resources\Objects\TestClosedObject;
use PHPUnit\Framework\TestCase;

class SchemaClosedTest extends TestCase
{
    /** @var TestClosedObject */
    private $object;

    /** @var ObjectSchema */
    private $schema;

    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new TestClosedObject();
        $this->schema = new ObjectSchema($this->object);
    }

    public function test_it_throws_error_when_no_property_is_found()
    {
        $this->expectException(PropertyAccessNotFound::class);

        $this->schema->getId();
    }
}
