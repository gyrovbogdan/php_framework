<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;
use Framework\Exceptions\ContainerException;
use ReflectionNamedType;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

    public function addDefinitions(array $containerDefinitions)
    {
        $this->definitions = [...$this->definitions, ...$containerDefinitions];
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);
        if (!$reflectionClass->isInstantiable())
            throw new ContainerException("Class $className is not instantiable.");


        $constructor = $reflectionClass->getConstructor();
        if (!$constructor)
            return new $className;

        $params = $constructor->getParameters();
        if (count($params) === 0)
            return new $className;

        $dependencies = [];

        foreach ($params as $param) {
            $type = $param->getType();
            $name = $param->getName();

            if (!$type)
                throw new ContainerException(
                    "Failed to resolve class $className, 
                    because he has parameter $name, that has no type."
                );

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin())
                throw new ContainerException(
                    "Failed to resolve class $className, 
                    because he has parameter $name, that nas invalid param name."
                );

            $dependencies[] = $this->get($type->getName());
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions))
            throw new ContainerException("Class $id does not exists in container.");

        if (array_key_exists($id, $this->resolved))
            return $this->resolved[$id];

        $factory = $this->definitions[$id];
        $dependency = $factory($this);

        $this->resolved[$id] = $dependency;
        return $dependency;
    }
}
