-- Bezpieczne dane demo. Bez haseł do urządzeń i kodów alarmowych.
SET TIME ZONE 'Europe/Warsaw';

INSERT INTO clients (name, email, phone) VALUES
    ('Anna Nowak', 'anna.nowak@example.com', '+48 600 000 000'),
    ('Jan Kowalski', 'jan.kowalski@example.com', NULL),
    ('Sklep „Pod Dębem”', NULL, NULL),
    ('Biuro Lex', 'biuro@lex.example.com', NULL),
    ('Maria Wójcik', NULL, NULL);

-- Konta demo. Wszystkie mają to samo hasło demo (patrz README), w bazie tylko hash bcrypt.
INSERT INTO users (client_id, name, email, password_hash, role) VALUES
    (NULL, 'Marta Zielińska', 'marta.zielinska@serwisbook.example', '$2y$10$EQx7JM7A3q.D96AAwjkMUOcOGAjG6UNwGR.3EqgsJlmpt1oPdfdXK', 'admin'),
    (NULL, 'Piotr Wiśniewski', 'piotr.wisniewski@serwisbook.example', '$2y$10$EQx7JM7A3q.D96AAwjkMUOcOGAjG6UNwGR.3EqgsJlmpt1oPdfdXK', 'technician'),
    (NULL, 'Tomasz Lis', 'tomasz.lis@serwisbook.example', '$2y$10$EQx7JM7A3q.D96AAwjkMUOcOGAjG6UNwGR.3EqgsJlmpt1oPdfdXK', 'technician'),
    (1, 'Anna Nowak', 'anna.nowak@example.com', '$2y$10$EQx7JM7A3q.D96AAwjkMUOcOGAjG6UNwGR.3EqgsJlmpt1oPdfdXK', 'client'),
    (2, 'Jan Kowalski', 'jan.kowalski@example.com', '$2y$10$EQx7JM7A3q.D96AAwjkMUOcOGAjG6UNwGR.3EqgsJlmpt1oPdfdXK', 'client');

INSERT INTO installations (client_id, site_name, address, type, installed_at, next_inspection, inspection_note) VALUES
    (1, 'Dom', 'ul. Lipowa 12, Kraków', 'Alarm, monitoring i sieć', '2025-03-14', '2026-11-14', 'wymiana akumulatora centrali'),
    (2, NULL, 'ul. Polna 3, Skawina', 'System alarmowy', '2024-12-02', '2026-12-02', NULL),
    (3, NULL, 'Rynek 4, Wieliczka', 'System alarmowy', '2024-11-21', '2026-11-21', NULL),
    (4, NULL, 'ul. Długa 21, Kraków', 'Monitoring i sieć', '2025-12-09', '2026-12-09', NULL),
    (5, NULL, 'ul. Rynek 7, Myślenice', 'System alarmowy', '2025-05-20', '2027-05-20', NULL);

INSERT INTO devices (installation_id, name, place, state) VALUES
    (1, 'Centrala alarmowa', 'Garaż, szafka techniczna', 'battery_low'),
    (1, 'Czujnik ruchu', 'Salon, strefa 1', 'ok'),
    (1, 'Kamera IP – ogród', 'Elewacja tylna, kanał 3', 'failure'),
    (1, 'Kamera IP – wjazd', 'Elewacja przednia, kanał 1', 'ok'),
    (1, 'Rejestrator NVR', '8 kanałów, szafka techniczna', 'ok'),
    (1, 'Switch PoE', 'Szafka techniczna', 'ok');

-- Identyfikatory zgłoszeń 1038-1045 jak w przykładowych danych aplikacji.
ALTER TABLE tickets ALTER COLUMN id RESTART WITH 1038;

INSERT INTO tickets (installation_id, category, title, description, status, urgent, technician, visit_time, created_at, updated_at) VALUES
    (5, 'Inne', 'Pytanie o rozbudowę instalacji', 'Klientka pyta o dodanie czujnika w garażu.', 'done', FALSE, 'Tomasz Lis', NULL, '2026-10-27 16:44', '2026-10-27 16:44'),
    (3, 'Fałszywe alarmy', 'Fałszywe alarmy w nocy', 'W nocy kilkukrotnie włączał się alarm bez przyczyny.', 'done', FALSE, 'Piotr Wiśniewski', NULL, '2026-10-28 07:50', '2026-10-28 07:50'),
    (2, 'Alarm zgłasza błąd', 'Centrala sygnalizuje niski akumulator', 'Centrala co kilka minut sygnalizuje niski poziom akumulatora.', 'new', FALSE, NULL, NULL, '2026-10-31 09:30', '2026-10-31 09:30'),
    (4, 'Brak połączenia z siecią', 'Brak połączenia z rejestratorem', 'Rejestrator nie jest widoczny w sieci biura.', 'in_progress', FALSE, 'Tomasz Lis', NULL, '2026-10-31 14:02', '2026-10-31 14:02'),
    (1, 'Kamera nie działa', 'Kamera nie łączy się z rejestratorem', 'Kamera od strony ogrodu od wczoraj wieczorem pokazuje czarny obraz. Pozostałe trzy kamery działają normalnie.', 'assigned', TRUE, 'Piotr Wiśniewski', '09:00', '2026-11-01 21:15', '2026-11-02 07:40'),
    (3, 'Inne', 'Przegląd roczny systemu alarmowego', 'Coroczny przegląd systemu alarmowego.', 'scheduled', FALSE, 'Piotr Wiśniewski', '11:30', '2026-10-30 08:00', '2026-10-30 08:00'),
    (2, 'Alarm zgłasza błąd', 'Wymiana akumulatora w centrali', 'Centrala sygnalizuje niski poziom akumulatora.', 'in_progress', FALSE, 'Piotr Wiśniewski', '14:00', '2026-10-31 09:30', '2026-10-31 09:30'),
    (4, 'Brak połączenia z siecią', 'Konfiguracja sieci i kamer IP', 'Konfiguracja sieci i dodanie kamer IP do rejestratora.', 'scheduled', FALSE, 'Piotr Wiśniewski', '16:00', '2026-11-01 10:20', '2026-11-01 10:20');

INSERT INTO ticket_history (ticket_id, occurred_at, description) VALUES
    (1042, '2026-11-01 21:15', 'zgłoszenie utworzone przez klienta'),
    (1042, '2026-11-02 07:40', 'przypisano do technika');
