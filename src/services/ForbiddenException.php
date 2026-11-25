<?php

declare(strict_types=1);

namespace App\Service;

/** Użytkownik nie ma uprawnień do zasobu (HTTP 403). */
final class ForbiddenException extends \RuntimeException
{
}
