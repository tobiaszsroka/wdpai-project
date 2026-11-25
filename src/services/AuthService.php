<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\RegisterData;
use App\Model\User;
use App\Repository\EmailAlreadyUsedException;
use App\Repository\UserRepositoryInterface;

final class AuthService
{
    public const PASSWORD_MIN_LENGTH = 8;

    /** Hash do „pustej” weryfikacji, aby czas odpowiedzi nie zdradzał, czy e-mail istnieje. */
    private const DUMMY_HASH = '$2y$10$usesomesillystringforsalt.4Tn3k0bJmhbaQ0Xc3xBQvUBpFUxDq';

    public function __construct(private readonly UserRepositoryInterface $users)
    {
    }

    /**
     * Tworzy konto klienta (rola jest zawsze „klient”, użytkownik jej nie wybiera).
     *
     * @throws ValidationException gdy dane są niepoprawne
     */
    public function registerClient(RegisterData $data): User
    {
        $name = trim($data->name);
        $email = mb_strtolower(trim($data->email));
        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Podaj imię i nazwisko.';
        } elseif (mb_strlen($name) > 120) {
            $errors['name'] = 'Imię i nazwisko może mieć najwyżej 120 znaków.';
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || mb_strlen($email) > 255) {
            $errors['email'] = 'Podaj poprawny adres e-mail.';
        }

        if (mb_strlen($data->password) < self::PASSWORD_MIN_LENGTH) {
            $errors['password'] = 'Hasło musi mieć co najmniej ' . self::PASSWORD_MIN_LENGTH . ' znaków.';
        } elseif ($data->password !== $data->passwordConfirmation) {
            $errors['passwordConfirmation'] = 'Hasła nie są takie same.';
        }

        if ($errors !== []) {
            throw new ValidationException($errors);
        }

        $user = User::register($name, $email, $data->password);

        try {
            $this->users->saveClientAccount($user, $name);
        } catch (EmailAlreadyUsedException) {
            // Ten sam komunikat co przy innych błędach pola e-mail, bez ujawniania szczegółów konta.
            throw new ValidationException(['email' => 'Nie można utworzyć konta dla tego adresu e-mail.']);
        }

        return $user;
    }

    /** Zwraca użytkownika po poprawnym logowaniu albo null (bez wskazywania, co było błędne). */
    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->users->findByEmail(mb_strtolower(trim($email)));

        if ($user === null) {
            password_verify($password, self::DUMMY_HASH);

            return null;
        }

        return $user->verifyPassword($password) ? $user : null;
    }
}
