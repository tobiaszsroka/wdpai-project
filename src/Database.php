<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $database,
        private readonly string $username,
        private readonly string $password,
    ) {
    }

    /** Konfiguracja pochodzi ze zmiennych środowiskowych (plik .env, bez haseł w kodzie). */
    public static function fromEnvironment(): self
    {
        return new self(
            self::requireEnv('DB_HOST'),
            (int) self::requireEnv('DB_PORT'),
            self::requireEnv('POSTGRES_DB'),
            self::requireEnv('POSTGRES_USER'),
            self::requireEnv('POSTGRES_PASSWORD'),
        );
    }

    public function connect(): PDO
    {
        $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $this->host, $this->port, $this->database);

        try {
            $connection = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            $connection->exec("SET TIME ZONE 'Europe/Warsaw'");

            return $connection;
        } catch (PDOException $exception) {
            // Szczegóły (host, nazwa bazy) trafiają tylko do logu, nie do użytkownika.
            error_log('Database connection failed: ' . $exception->getMessage());

            throw new RuntimeException('Nie udało się połączyć z bazą danych.', 0, $exception);
        }
    }

    private static function requireEnv(string $name): string
    {
        $value = getenv($name);

        if ($value === false || $value === '') {
            throw new RuntimeException('Brak zmiennej środowiskowej: ' . $name);
        }

        return $value;
    }
}
