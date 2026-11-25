<?php

declare(strict_types=1);

namespace App\Service;

/** Brak zalogowanego użytkownika (HTTP 401). */
final class UnauthenticatedException extends \RuntimeException
{
}
