<?php

declare(strict_types=1);

namespace App\Model;

final class User
{
    public function __construct(
        private ?int $id,
        private readonly string $name,
        private readonly string $email,
        private readonly UserRole $role,
        private readonly ?int $clientId,
        private readonly string $passwordHash,
    ) {
        if (trim($name) === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('User needs a name and a valid e-mail.');
        }
    }

    /** Tworzy nowego użytkownika z hasła podanego jawnie; w obiekcie zostaje tylko hash. */
    public static function register(
        string $name,
        string $email,
        string $plainPassword,
        UserRole $role = UserRole::Client,
        ?int $clientId = null,
    ): self {
        return new self(null, $name, $email, $role, $clientId, password_hash($plainPassword, PASSWORD_DEFAULT));
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->passwordHash);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    /** Dla konta klienta identyfikator klienta, któremu należą instalacje i zgłoszenia. */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /** Tylko dla repozytorium (zapis do bazy). Widoki i kontrolery nie powinny tego używać. */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
