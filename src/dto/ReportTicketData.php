<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * DTO: dane formularza „Zgłoś usterkę” w drodze od kontrolera do serwisu.
 * Bez logiki i bez walidacji, tylko przenosi wartości.
 */
final class ReportTicketData
{
    public function __construct(
        public readonly int $installationId,
        public readonly string $category,
        public readonly string $description,
    ) {
    }
}
