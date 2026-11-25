<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;

interface UserRepositoryInterface
{
    /** Wyszukiwanie bez rozróżniania wielkości liter. */
    public function findByEmail(string $email): ?User;

    /**
     * Tworzy klienta i jego konto w jednej transakcji. Ustawia id użytkownika.
     *
     * @throws EmailAlreadyUsedException gdy adres jest już zajęty
     */
    public function saveClientAccount(User $user, string $clientName): void;
}
