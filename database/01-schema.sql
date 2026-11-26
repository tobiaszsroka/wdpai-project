-- SerwisBook: schemat bazy danych (PostgreSQL 16).
-- Skrypt jest wykonywany automatycznie przy pierwszym starcie pustego wolumenu db.

CREATE TABLE clients (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(30) NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    client_id BIGINT NULL,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'client',
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT users_client_fk
        FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE,
    CONSTRAINT users_role_check CHECK (role IN ('client', 'technician', 'admin')),
    -- Konto klienta jest powiązane z klientem, konta firmy (technik, administrator) nie.
    CONSTRAINT users_client_link_check CHECK ((role = 'client') = (client_id IS NOT NULL))
);

CREATE UNIQUE INDEX users_email_unique ON users (LOWER(email));

CREATE TABLE installations (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    client_id BIGINT NOT NULL,
    site_name VARCHAR(100) NULL,
    address VARCHAR(200) NOT NULL,
    type VARCHAR(100) NOT NULL,
    installed_at DATE NOT NULL,
    next_inspection DATE NOT NULL,
    inspection_note VARCHAR(200) NULL,
    CONSTRAINT installations_client_fk
        FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE RESTRICT,
    CONSTRAINT installations_dates_check CHECK (next_inspection >= installed_at)
);

CREATE TABLE devices (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    installation_id BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    place VARCHAR(150) NOT NULL,
    state VARCHAR(20) NOT NULL DEFAULT 'ok',
    CONSTRAINT devices_installation_fk
        FOREIGN KEY (installation_id) REFERENCES installations (id) ON DELETE CASCADE,
    CONSTRAINT devices_state_check CHECK (state IN ('ok', 'battery_low', 'failure'))
);

CREATE TABLE tickets (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    installation_id BIGINT NOT NULL,
    category VARCHAR(100) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'new',
    urgent BOOLEAN NOT NULL DEFAULT FALSE,
    technician VARCHAR(100) NULL,
    visit_time TIME NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT tickets_installation_fk
        FOREIGN KEY (installation_id) REFERENCES installations (id) ON DELETE RESTRICT,
    CONSTRAINT tickets_status_check
        CHECK (status IN ('new', 'scheduled', 'assigned', 'in_progress', 'waiting_for_part', 'done'))
);

CREATE TABLE ticket_history (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    ticket_id BIGINT NOT NULL,
    occurred_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(200) NOT NULL,
    CONSTRAINT ticket_history_ticket_fk
        FOREIGN KEY (ticket_id) REFERENCES tickets (id) ON DELETE CASCADE
);

CREATE INDEX installations_client_idx ON installations (client_id);
CREATE INDEX devices_installation_idx ON devices (installation_id);
CREATE INDEX tickets_installation_idx ON tickets (installation_id);
CREATE INDEX tickets_status_idx ON tickets (status);
CREATE INDEX tickets_created_at_idx ON tickets (created_at DESC);
CREATE INDEX ticket_history_ticket_idx ON ticket_history (ticket_id, occurred_at DESC);
