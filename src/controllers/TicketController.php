<?php

declare(strict_types=1);

namespace App\Controller;

final class TicketController extends AppController
{
    public function index(): void
    {
        $this->render('tickets', [
            'pageTitle' => 'Zgłoszenia serwisowe',
            'active' => 'tickets',
            'userName' => 'Marta Zielińska',
            'userRole' => 'Administrator',
            'technicians' => ['Piotr Wiśniewski', 'Tomasz Lis'],
            'tickets' => [
                ['id' => 1042, 'client' => 'Anna Nowak', 'category' => 'Kamera nie działa', 'created' => '01.11, 21:15', 'technician' => 'Piotr Wiśniewski', 'status' => 'Pilne', 'tone' => 'bad'],
                ['id' => 1041, 'client' => 'Biuro Lex', 'category' => 'Brak połączenia z siecią', 'created' => '31.10, 14:02', 'technician' => 'Tomasz Lis', 'status' => 'W toku', 'tone' => 'warn'],
                ['id' => 1040, 'client' => 'Jan Kowalski', 'category' => 'Alarm zgłasza błąd', 'created' => '31.10, 09:30', 'technician' => null, 'status' => 'Nowe', 'tone' => 'info'],
                ['id' => 1039, 'client' => 'Sklep „Pod Dębem”', 'category' => 'Fałszywe alarmy', 'created' => '28.10, 07:50', 'technician' => 'Piotr Wiśniewski', 'status' => 'Zakończone', 'tone' => 'ok'],
                ['id' => 1038, 'client' => 'Maria Wójcik', 'category' => 'Inne', 'created' => '27.10, 16:44', 'technician' => 'Tomasz Lis', 'status' => 'Zakończone', 'tone' => 'ok'],
            ],
        ]);
    }

    public function mobileIndex(): void
    {
        $this->render('mobile/tasks', [
            'pageTitle' => 'Moje zadania',
            'today' => 'Poniedziałek, 2 listopada',
            'technician' => 'Piotr Wiśniewski',
            'tasks' => [
                ['id' => 1042, 'time' => '09:00', 'status' => 'Pilne', 'tone' => 'bad', 'title' => 'Kamera nie łączy się z rejestratorem', 'place' => 'Anna Nowak · ul. Lipowa 12, Kraków'],
                ['id' => 1043, 'time' => '11:30', 'status' => 'Zaplanowane', 'tone' => 'info', 'title' => 'Przegląd roczny systemu alarmowego', 'place' => 'Sklep „Pod Dębem” · Rynek 4, Wieliczka'],
                ['id' => 1044, 'time' => '14:00', 'status' => 'W toku', 'tone' => 'warn', 'title' => 'Wymiana akumulatora w centrali', 'place' => 'Jan Kowalski · ul. Polna 3, Skawina'],
                ['id' => 1045, 'time' => '16:00', 'status' => 'Zaplanowane', 'tone' => 'info', 'title' => 'Konfiguracja sieci i kamer IP', 'place' => 'Biuro Lex · ul. Długa 21, Kraków'],
            ],
        ]);
    }

    public function mobileShow(int $id): void
    {
        $this->render('mobile/ticket', [
            'pageTitle' => 'Zgłoszenie #' . $id,
            'ticket' => [
                'id' => $id,
                'status' => 'Przypisane',
                'title' => 'Kamera nie łączy się z rejestratorem',
                'place' => 'Anna Nowak · ul. Lipowa 12, Kraków',
                'description' => 'Kamera od strony ogrodu od wczoraj wieczorem pokazuje czarny obraz. Pozostałe trzy kamery działają normalnie.',
                'history' => [
                    ['02.11, 07:40', 'przypisano do technika'],
                    ['01.11, 21:15', 'zgłoszenie utworzone przez klienta'],
                ],
            ],
        ]);
    }

    public function mobileReport(): void
    {
        $this->render('mobile/report', [
            'pageTitle' => 'Zgłoś usterkę',
            'installations' => ['Dom, ul. Lipowa 12 – monitoring i alarm', 'Garaż, ul. Polna 3 – alarm'],
            'categories' => ['Kamera nie działa', 'Alarm zgłasza błąd', 'Brak połączenia z siecią', 'Inne'],
        ]);
    }
}
