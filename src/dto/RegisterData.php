<?php

declare(strict_types=1);

namespace App\Dto;

/** DTO: dane formularza rejestracji klienta. */
final class RegisterData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirmation,
    ) {
    }
}
