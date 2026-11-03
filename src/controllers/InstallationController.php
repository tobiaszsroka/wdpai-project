<?php

declare(strict_types=1);

namespace App\Controller;

final class InstallationController extends AppController
{
    // Dane przykładowe. W kolejnych zadaniach zastąpi je baza danych.
    private const INSTALLATIONS = [
        1 => [
            'client' => 'Anna Nowak',
            'address' => 'ul. Lipowa 12, Kraków',
            'type' => 'Alarm, monitoring i sieć',
            'nextInspection' => '2026-11-14',
        ],
        2 => [
            'client' => 'Jan Kowalski',
            'address' => 'ul. Polna 3, Skawina',
            'type' => 'System alarmowy',
            'nextInspection' => '2026-12-02',
        ],
        3 => [
            'client' => 'Sklep „Pod Dębem”',
            'address' => 'Rynek 4, Wieliczka',
            'type' => 'System alarmowy',
            'nextInspection' => '2026-11-21',
        ],
    ];

    public function index(): void
    {
        $this->render('installations', [
            'pageTitle' => 'Instalacje',
            'installations' => self::INSTALLATIONS,
        ]);
    }

    public function show(int $id): void
    {
        $installation = self::INSTALLATIONS[$id] ?? null;

        if ($installation === null) {
            http_response_code(404);
            (new DefaultController())->notFound();

            return;
        }

        $this->render('installation', [
            'pageTitle' => 'Instalacja: ' . $installation['client'],
            'installationId' => $id,
            'installation' => $installation,
        ]);
    }

    public function mobileCard(): void
    {
        $this->render('mobile/installation', [
            'pageTitle' => 'Karta instalacji',
            'installation' => [
                'client' => 'Anna Nowak',
                'address' => 'Dom, ul. Lipowa 12, Kraków',
                'type' => 'Alarm + monitoring + sieć',
                'since' => '14.03.2025',
                'inspection' => '14.11.2026',
                'daysLeft' => 12,
                'devices' => [
                    ['name' => 'Centrala alarmowa', 'place' => 'Garaż, szafka techniczna', 'state' => 'Akumulator', 'tone' => 'warn'],
                    ['name' => 'Czujnik ruchu', 'place' => 'Salon, strefa 1', 'state' => 'OK', 'tone' => 'ok'],
                    ['name' => 'Kamera IP – ogród', 'place' => 'Elewacja tylna, kanał 3', 'state' => 'Awaria', 'tone' => 'bad'],
                    ['name' => 'Kamera IP – wjazd', 'place' => 'Elewacja przednia, kanał 1', 'state' => 'OK', 'tone' => 'ok'],
                    ['name' => 'Rejestrator NVR', 'place' => '8 kanałów, szafka techniczna', 'state' => 'OK', 'tone' => 'ok'],
                    ['name' => 'Switch PoE', 'place' => 'Szafka techniczna', 'state' => 'OK', 'tone' => 'ok'],
                ],
            ],
        ]);
    }
}
