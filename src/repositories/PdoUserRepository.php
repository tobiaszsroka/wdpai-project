<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;
use App\Model\UserRole;
use PDO;
use PDOException;

final class PdoUserRepository implements UserRepositoryInterface
{
    private const UNIQUE_VIOLATION = '23505';

    public function __construct(private readonly PDO $database)
    {
    }

    public function findByEmail(string $email): ?User
    {
        $statement = $this->database->prepare(
            'SELECT id, client_id, name, email, password_hash, role
             FROM users
             WHERE LOWER(email) = LOWER(:email)
             LIMIT 1',
        );
        $statement->execute(['email' => $email]);
        $row = $statement->fetch();

        return $row === false ? null : $this->mapRowToUser($row);
    }

    public function saveClientAccount(User $user, string $clientName): void
    {
        $this->database->beginTransaction();

        try {
            $client = $this->database->prepare(
                'INSERT INTO clients (name, email) VALUES (:name, :email) RETURNING id',
            );
            $client->execute(['name' => $clientName, 'email' => $user->getEmail()]);
            $clientId = (int) $client->fetchColumn();

            $account = $this->database->prepare(
                'INSERT INTO users (client_id, name, email, password_hash, role)
                 VALUES (:client_id, :name, :email, :password_hash, :role)
                 RETURNING id',
            );
            $account->execute([
                'client_id' => $clientId,
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password_hash' => $user->getPasswordHash(),
                'role' => UserRole::Client->value,
            ]);

            $userId = (int) $account->fetchColumn();
            $this->database->commit();
            $user->setId($userId);
        } catch (PDOException $exception) {
            $this->database->rollBack();

            if ($exception->getCode() === self::UNIQUE_VIOLATION) {
                throw new EmailAlreadyUsedException('E-mail already registered.', 0, $exception);
            }

            throw $exception;
        }
    }

    /** @param array<string, mixed> $row */
    private function mapRowToUser(array $row): User
    {
        return new User(
            id: (int) $row['id'],
            name: (string) $row['name'],
            email: (string) $row['email'],
            role: UserRole::from((string) $row['role']),
            clientId: $row['client_id'] === null ? null : (int) $row['client_id'],
            passwordHash: (string) $row['password_hash'],
        );
    }
}
