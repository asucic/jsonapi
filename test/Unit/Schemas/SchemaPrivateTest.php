<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Test\Unit\Schemas;

use ASucic\JsonApi\Schemas\ObjectSchema;
use ASucic\JsonApi\Test\Resources\Objects\TestPrivateObject;
use PHPUnit\Framework\TestCase;

class SchemaPrivateTest extends TestCase
{
    /** @var TestPrivateObject */
    private $object;

    /** @var ObjectSchema */
    private $schema;

    protected function setUp(): void
    {
        parent::setUp();

        $this->object = new TestPrivateObject();
        $this->schema = new ObjectSchema($this->object);
    }

    public function test_it_can_get_identifier_from_object()
    {
        $this->assertEquals((string) 1, $this->schema->getId());
    }
}
