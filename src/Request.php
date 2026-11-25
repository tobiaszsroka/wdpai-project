<?php

declare(strict_types=1);

namespace App;

/**
 * Dane bieżącego żądania HTTP. Wartości tablicowe (np. ?status[]=1) są ignorowane.
 */
final class Request
{
    /**
     * @param array<string, mixed> $query
     * @param array<string, mixed> $post
     */
    public function __construct(
        private readonly string $method,
        private readonly array $query = [],
        private readonly array $post = [],
    ) {
    }

    public static function fromGlobals(): self
    {
        return new self($_SERVER['REQUEST_METHOD'] ?? 'GET', $_GET, $_POST);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function query(string $key): ?string
    {
        return is_string($this->query[$key] ?? null) ? $this->query[$key] : null;
    }

    public function post(string $key): ?string
    {
        return is_string($this->post[$key] ?? null) ? $this->post[$key] : null;
    }
}
