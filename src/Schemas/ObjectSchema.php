<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Schemas;

use ASucic\JsonApi\Exceptions\PropertyAccessNotFound;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

class ObjectSchema implements SchemaInterface
{
    protected $id;
    protected $attributes;
    protected $relationships;

    /** @var ReflectionClass */
    private $reflect;
    private $object;

    private const PROPERTY_IDENTIFIER = 'id';
    private const GET_METHOD_PREFIXES = [
        'get',
        'is',
        'has',
    ];
    private const SET_METHOD_PREFIXES = [
        'set',
        'add',
    ];

    public function __construct(object $object)
    {
        $this->reflect = new ReflectionClass($object);
        $this->object = $object;
    }

    /** @throws PropertyAccessNotFound */
    public function getId(): string
    {
        $property = self::PROPERTY_IDENTIFIER;
        if (is_string($this->id) && !empty(trim($this->id))) {
            $property = $this->id;
        }

        if ($identifier = $this->findProperty($property)) {
            $identifier->getValue($this->object);
        }

        if ($getter = $this->findGetter($property)) {
            $getter->invoke($this->object);
        }

        throw new PropertyAccessNotFound($property);
    }

    public function getAttributes(): array
    {
        $attributes = [];
        foreach ($this->reflect->getProperties() as $property) {
            $attributes[] = $property->getDeclaringClass();
        }

        return $attributes;
    }

    public function getRelationships(): array
    {
        $attributes = [];
        foreach ($this->reflect->getProperties() as $property) {
            $attributes[] = $property->getDeclaringClass();
        }

        return $attributes;
    }

    // public function getDefaultIdentifier

    private function findProperty(string $property): ?ReflectionProperty
    {
        try {
            $identifier = $this->reflect->getProperty($property);
            if ($identifier->isPublic()) {
                return $identifier;
            }
        } catch (ReflectionException $exception) {
            // Continue if identifier was not found
        }

        return null;
    }

    private function findGetter(string $property): ?ReflectionMethod
    {
        $property = ucfirst($property);
        foreach (self::GET_METHOD_PREFIXES as $prefix) {
            try {
                $method = $this->reflect->getMethod("$prefix$property");
            } catch (ReflectionException $exception) {
                continue;
            }

            if ($method && $method->isPublic()) {
                return $method;
            }
        }

        return null;
    }
}
