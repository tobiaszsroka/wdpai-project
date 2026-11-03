<?php

declare(strict_types=1);

namespace App\Controller;

final class DashboardController extends AppController
{
    public function index(): void
    {
        $this->render('dashboard', [
            'pageTitle' => 'Panel główny',
            'active' => 'dashboard',
            'userName' => 'Marta Zielińska',
            'userRole' => 'Administrator',
            'today' => 'Poniedziałek, 2 listopada 2026',
            'stats' => [
                'Otwarte zgłoszenia' => 7,
                'Pilne' => 2,
                'Przeglądy w 30 dni' => 11,
                'Protokoły w tym miesiącu' => 18,
            ],
            'tickets' => [
                ['id' => 1042, 'client' => 'Anna Nowak', 'problem' => 'Kamera ogród nie działa', 'status' => 'Pilne', 'tone' => 'bad'],
                ['id' => 1041, 'client' => 'Biuro Lex', 'problem' => 'Brak połączenia z rejestratorem', 'status' => 'W toku', 'tone' => 'warn'],
                ['id' => 1040, 'client' => 'Jan Kowalski', 'problem' => 'Centrala sygnalizuje niski akumulator', 'status' => 'Nowe', 'tone' => 'info'],
                ['id' => 1039, 'client' => 'Sklep „Pod Dębem”', 'problem' => 'Fałszywe alarmy w nocy', 'status' => 'Zakończone', 'tone' => 'ok'],
            ],
            'inspections' => [
                ['client' => 'Anna Nowak, ul. Lipowa 12', 'date' => '14.11'],
                ['client' => 'Sklep „Pod Dębem”', 'date' => '21.11'],
                ['client' => 'Jan Kowalski, ul. Polna 3', 'date' => '02.12'],
                ['client' => 'Biuro Lex, ul. Długa 21', 'date' => '09.12'],
            ],
        ]);
    }
}
