# CRM

Web-based CRM for client and deal management with role-based access (administrator, head, manager). Built with Laravel 12, Blade, Alpine.js, and Tailwind. Includes personal tools (tasks, notes, calendar, reminders), file attachments, soft-delete archival, and i18n (EN/UA/RU). Local development via Laravel Sail.

## Documentation

- [Architecture](ARCHITECTURE.md) — system overview, data flow, modules, authorization
- [Database schema](DB_SCHEMA.md) — ER diagram (Mermaid)
- [Class diagram](CLASS_DIAGRAM.md) — controllers, policies, models (Mermaid)

## Test Data & Demo Accounts

After seeding the database, predefined users and sample business data are available for local testing.

### Seeding

```bash
./vendor/bin/sail artisan migrate --seed
```

Seeders run in order: `AdminSeeder` (roles + admin if no users exist), then `FakeDataSeeder` (head, managers, clients, deals).

### Demo Accounts

All accounts use password: **`password`**. Sign in at `/login` with email + password. Self-registration is not available.

| Role | Email | Name | Seeder |
|------|-------|------|--------|
| Administrator | `admin@mail.com` | Administrator | `AdminSeeder` (only when the users table is empty) |
| Head | `master@mail.com` | Master Head | `FakeDataSeeder` |
| Manager | `manager1@mail.com` | Manager 1 | `FakeDataSeeder` |
| Manager | `manager2@mail.com` | Manager 2 | `FakeDataSeeder` |

`UserFactory` is used in automated tests to generate random users (default password `password`). Fixed demo accounts are defined in seeders only.

### Sample Business Data

`FakeDataSeeder` creates:

- **30 clients** — 10 potential, 5 soft-deleted (archive), 5 loyal active, 10 regular active
- **100 deals** — distributed across clients
- **Reference statuses** — client: `potential`, `active`; deal: `in_progress`, `active`, `completed`

### Role Capabilities

**Administrator**

- Full access to all clients and deals
- System settings (`/settings`) and status directories (CRUD + archive)
- System log viewer (`/log-viewer`)
- User management (all roles)
- Personal tools (tasks, note, calendar, reminders) and profile (name, avatar, password; email is immutable)

**Head**

- All business data (clients, deals, dashboard with global KPIs)
- Manager management: list, detail, assign clients, enable/disable managers
- User management: create/edit users with `manager` or `head` roles (not `admin`)
- Status directories: full CRUD + archive at `/settings/client-statuses` and `/settings/deal-statuses`
- Personal tools and profile (own data only)
- No access to system settings (app name/locale) or system log

**Manager**

- Own clients only (`manager_id` matches the logged-in user) and their deals
- Can **create** clients; `manager_id` is set automatically to the current user on create
- CRUD, archive, and restore for own clients and deals
- Dashboard KPIs scoped to own data
- Personal tools and profile (own data only)
- No access to managers, users, status directories, or system settings

**All roles**

- Locale switcher (EN / UA / RU)
- Light/dark theme
- File uploads on client and deal detail pages

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or Docker Engine + Docker Compose)
- Git
- Composer (for initial dependency installation on the host)

> All `artisan`, `composer`, `npm`, and `php` commands in day-to-day work run through Sail: `./vendor/bin/sail …`

---

## Installation from Repository

```bash
git clone <repository-url> crm
cd crm
```

### 1. PHP Dependencies

```bash
composer install
```

### 2. Environment

```bash
cp .env.example .env
```

Verify database variables in `.env` — they must match `compose.yaml`:

| Variable        | Value      | Notes                                              |
|-----------------|------------|----------------------------------------------------|
| `DB_CONNECTION` | `mysql`    | Not `sqlite`                                       |
| `DB_HOST`       | `mysql`    | Docker service name, **not** `127.0.0.1`           |
| `DB_PORT`       | `3306`     |                                                    |
| `DB_DATABASE`   | `crm`      |                                                    |
| `DB_USERNAME`   | `sail`     | User created by the MySQL container                |
| `DB_PASSWORD`   | `password` | Must match the root password in the container      |

Set Sail user identifiers (Linux/macOS):

```bash
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env
```

### 3. Start Containers

```bash
./vendor/bin/sail up -d
```

### 4. Initialize Application

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

The application is available at [http://localhost](http://localhost). Use the [demo accounts](#demo-accounts) above to sign in.

---

## Fresh Install (without `laravel new`)

Create a new project via Composer with an explicit Laravel version. The `laravel new` command is **not used**.

### 1. Create Project

```bash
composer create-project laravel/laravel:^12.0 crm
cd crm
```

### 2. Laravel Sail + MySQL

```bash
composer require laravel/sail --dev
php artisan sail:install --with=mysql --no-interaction
```

> If `compose.yaml` already exists in the repository (as in this project), skip the `sail:install` step.

### 3. Environment

```bash
cp .env.example .env
```

Configure `.env` using the table above (`DB_HOST=mysql`, `DB_USERNAME=sail`, `DB_PASSWORD=password`, etc.) and add `WWWUSER` / `WWWGROUP`:

```bash
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env
```

### 4. Start

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```
