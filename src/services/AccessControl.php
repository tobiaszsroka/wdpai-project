<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\UserRole;
use App\Session;

final class AccessControl
{
    public function __construct(private readonly Session $session)
    {
    }

    /**
     * @param list<UserRole>|null $allowedRoles null oznacza trasę publiczną
     *
     * @throws UnauthenticatedException gdy trasa wymaga konta, a nikt nie jest zalogowany
     * @throws ForbiddenException gdy rola użytkownika nie jest dozwolona
     */
    public function check(?array $allowedRoles): void
    {
        if ($allowedRoles === null) {
            return;
        }

        $role = $this->session->role();

        if ($role === null) {
            throw new UnauthenticatedException('Login required.');
        }

        if (!in_array($role, $allowedRoles, true)) {
            throw new ForbiddenException('Role not allowed.');
        }
    }
}
