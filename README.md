# CRM

Система управления клиентами и сделками на Laravel 12 + Sail.

## Требования

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (или Docker Engine + Docker Compose)
- Git
- Composer (для первоначальной установки зависимостей на хосте)

> Все команды `artisan`, `composer`, `npm` и `php` в работе выполняются через Sail: `./vendor/bin/sail …`

---

## Установка из репозитория

```bash
git clone <url-репозитория> crm
cd crm
```

### 1. Зависимости PHP

```bash
composer install
```

### 2. Окружение

```bash
cp .env.example .env
```

Проверьте переменные БД в `.env` — они должны совпадать с `compose.yaml`:

| Переменная       | Значение    | Комментарий                                      |
|------------------|-------------|--------------------------------------------------|
| `DB_CONNECTION`  | `mysql`     | Не `sqlite`                                      |
| `DB_HOST`        | `mysql`     | Имя сервиса Docker, **не** `127.0.0.1`           |
| `DB_PORT`        | `3306`      |                                                  |
| `DB_DATABASE`    | `crm`       |                                                  |
| `DB_USERNAME`    | `sail`      | Пользователь, которого создаёт контейнер MySQL     |
| `DB_PASSWORD`    | `password`  | Должен совпадать с паролем root в контейнере     |

Укажите идентификаторы пользователя для Sail (Linux/macOS):

```bash
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env
```

### 3. Запуск контейнеров

```bash
./vendor/bin/sail up -d
```

### 4. Инициализация приложения

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

Приложение доступно по адресу [http://localhost](http://localhost).

---

## Установка с нуля (без Laravel Installer)

Создание нового проекта выполняется через Composer с указанием версии Laravel. Команда `laravel new` **не используется**.

### 1. Создание проекта

```bash
composer create-project laravel/laravel:^12.0 crm
cd crm
```

### 2. Laravel Sail + MySQL

```bash
composer require laravel/sail --dev
php artisan sail:install --with=mysql --no-interaction
```

> Если `compose.yaml` уже есть в репозитории (как в этом проекте), шаг `sail:install` пропускается.

### 3. Окружение

```bash
cp .env.example .env
```

Настройте `.env` по таблице выше (`DB_HOST=mysql`, `DB_USERNAME=sail`, `DB_PASSWORD=password` и т. д.) и добавьте `WWWUSER` / `WWWGROUP`:

```bash
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env
```

### 4. Запуск

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

---

## Ежедневная работа

```bash
# Запуск контейнеров
./vendor/bin/sail up -d

# Остановка
./vendor/bin/sail stop

# Dev-сервер (Vite + queue + logs)
./vendor/bin/sail composer run dev

# Тесты
./vendor/bin/sail artisan test
```

---

## Типичные ошибки при установке

### Access denied for user 'sail'@'…'

**Причина:** в `.env` указан неверный хост, пользователь или пароль; либо MySQL-том был создан с другими учётными данными.

**Решение:**

1. Убедитесь, что `DB_HOST=mysql` (не `127.0.0.1` — это адрес только для подключения с хост-машины, например из GUI-клиента).
2. Проверьте, что `DB_USERNAME=sail` и `DB_PASSWORD=password` совпадают с `compose.yaml`.
3. Убедитесь, что `DB_CONNECTION=mysql` без опечаток.
4. Если том MySQL уже существовал с другими настройками — пересоздайте его:

```bash
./vendor/bin/sail down -v
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
```

### Переменные WWWUSER / WWWGROUP не заданы

Docker выводит предупреждение `The "WWWUSER" variable is not set`. Добавьте в `.env`:

```bash
echo "WWWUSER=$(id -u)" >> .env
echo "WWWGROUP=$(id -g)" >> .env
```

Затем пересоберите контейнеры:

```bash
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d
```

### Подключение к БД с хост-машины (TablePlus, DBeaver и т. п.)

| Параметр   | Значение      |
|------------|---------------|
| Host       | `127.0.0.1`   |
| Port       | `3306` (или значение `FORWARD_DB_PORT` из `.env`) |
| Database   | `crm`         |
| Username   | `sail`        |
| Password   | `password`    |
