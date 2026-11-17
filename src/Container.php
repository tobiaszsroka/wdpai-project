<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

/**
 * Minimalny kontener zależności: wiązania zdefiniowane w index.php,
 * a klasy bez wiązania (kontrolery) są tworzone z argumentami konstruktora
 * rozpoznanymi po typach.
 */
final class Container
{
    /** @var array<class-string, callable(self): object> */
    private array $factories = [];

    /** @var array<class-string, object> */
    private array $instances = [];

    /** @param callable(self): object $factory */
    public function bind(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
    }

    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $instance = isset($this->factories[$id])
            ? ($this->factories[$id])($this)
            : $this->autowire($id);

        return $this->instances[$id] = $instance;
    }

    private function autowire(string $class): object
    {
        if (!class_exists($class)) {
            throw new RuntimeException('Cannot resolve ' . $class);
        }

        $constructor = (new \ReflectionClass($class))->getConstructor();
        $arguments = [];

        foreach ($constructor?->getParameters() ?? [] as $parameter) {
            $type = $parameter->getType();

            if (!$type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                throw new RuntimeException('Cannot autowire ' . $class . '::$' . $parameter->getName());
            }

            $arguments[] = $this->get($type->getName());
        }

        return new $class(...$arguments);
    }
}
