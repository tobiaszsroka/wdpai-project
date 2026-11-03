<?php

declare(strict_types=1);

namespace App\Controller;

final class ClientController extends AppController
{
    public function index(): void
    {
        $this->render('clients', [
            'pageTitle' => 'Klienci i instalacje',
            'active' => 'clients',
            'userName' => 'Marta Zielińska',
            'userRole' => 'Administrator',
            'clients' => [
                ['name' => 'Anna Nowak', 'summary' => '2 instalacje · Kraków'],
                ['name' => 'Jan Kowalski', 'summary' => '1 instalacja · Skawina'],
                ['name' => 'Sklep „Pod Dębem”', 'summary' => '1 instalacja · Wieliczka'],
                ['name' => 'Biuro Lex', 'summary' => '3 instalacje · Kraków'],
                ['name' => 'Maria Wójcik', 'summary' => '1 instalacja · Myślenice'],
            ],
            'client' => [
                'name' => 'Anna Nowak',
                'contact' => 'anna.nowak@example.com · +48 600 000 000',
                'address' => 'ul. Lipowa 12, 30-001 Kraków',
            ],
            'installation' => [
                'title' => 'Dom, ul. Lipowa 12 · alarm + monitoring + sieć',
                'inspection' => '14.11.2026',
                'devices' => [
                    ['name' => 'Centrala alarmowa', 'place' => 'Garaż', 'date' => '14.03.2025', 'state' => 'Akumulator', 'tone' => 'warn'],
                    ['name' => 'Kamera IP – ogród', 'place' => 'Elewacja tylna', 'date' => '14.03.2025', 'state' => 'Awaria', 'tone' => 'bad'],
                    ['name' => 'Rejestrator NVR 8 kanałów', 'place' => 'Szafka techniczna', 'date' => '14.03.2025', 'state' => 'OK', 'tone' => 'ok'],
                ],
            ],
        ]);
    }
}
