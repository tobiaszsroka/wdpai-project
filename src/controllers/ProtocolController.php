<?php

declare(strict_types=1);

namespace App\Controller;

final class ProtocolController extends AppController
{
    public function index(): void
    {
        $this->render('protocols', [
            'pageTitle' => 'Protokół prac',
            'active' => 'protocols',
            'userName' => 'Piotr Wiśniewski',
            'userRole' => 'Technik',
            'protocol' => [
                'number' => 'P/2026/118',
                'date' => '02.11.2026',
                'type' => 'Monitoring wizyjny',
                'client' => 'Anna Nowak',
                'address' => 'ul. Lipowa 12, 30-001 Kraków',
                'technician' => 'Piotr Wiśniewski, technik',
                'devices' => [['Kamera IP – ogród', '1 szt.'], ['Zasilacz PoE', '1 szt.']],
                'description' => 'Wymiana uszkodzonej kamery, sprawdzenie okablowania, ponowne dodanie kamery w rejestratorze i test nagrywania.',
            ],
        ]);
    }
}
