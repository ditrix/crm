# Система кэширования CRM

Документ описывает внедрённую систему кэширования на Redis.  
Дата реализации: **2026-06-13**, ветка: **change_architecture**.

Связанная запись в дневнике: [`docs/changes/diary/2026/06/2026-06-13-cache-system.md`](changes/diary/2026/06/2026-06-13-cache-system.md)

---

## Цель

Снизить нагрузку на MySQL при одновременной работе нескольких пользователей. Справочники, страницы show Client/Deal и метрики dashboard запрашивались из БД на каждый HTTP-запрос — теперь они кэшируются в Redis с точечной инвалидацией при изменении данных.

---

## Инфраструктура

| Компонент | Значение |
|-----------|----------|
| Cache driver | `redis` (`CACHE_STORE=redis`) |
| Redis host (Sail) | `redis` (сервис в `compose.yaml`) |
| PHP-расширение | `phpredis` (`REDIS_CLIENT=phpredis`) |
| TTL entity/dashboard | 3600 сек (1 час) |
| TTL справочников | без expiry (`rememberForever`), сброс по событию |

В тестах (`phpunit.xml`) используется `CACHE_STORE=array` — это нормально, логика invalidator покрыта unit-тестами через mock.

---

## Архитектура

```
FormRequest → Controller → Service/Action → Model
                              ↓
                    ReferenceDataCache / Cache::remember
                              ↓
                           Redis
                              ↑
                    CacheInvalidator (при write)
```

### Новые классы

| Класс | Путь | Назначение |
|-------|------|------------|
| `CacheKey` | `app/Support/Cache/CacheKey.php` | Имена ключей кэша |
| `ReferenceDataCache` | `app/Services/Cache/ReferenceDataCache.php` | Чтение справочников |
| `CacheInvalidator` | `app/Services/Cache/CacheInvalidator.php` | Точечный сброс кэша |

---

## Что кэшируется

### Справочники (rememberForever)

| Ключ | Данные | Где используется |
|------|--------|------------------|
| `reference:client-statuses:ordered` | ClientStatus без удалённых | формы Client/Deal, фильтры |
| `reference:client-statuses:all` | ClientStatus с trashed | Settings |
| `reference:deal-statuses:ordered` | DealStatus без удалённых | формы Deal |
| `reference:deal-statuses:all` | DealStatus с trashed | Settings |
| `reference:managers:active` | активные User с ролью manager | формы Client, Manager |
| `reference:client-statuses:slug-map` | slug → id | dashboard links |
| `reference:deal-statuses:slug-map` | slug → id | dashboard links |

### Entity show (TTL 1 час)

| Ключ | Данные |
|------|--------|
| `client:{id}:show` | Client с relations: status, manager, deals.status, files, … |
| `deal:{id}:show` | Deal с relations: client, status, files, … |

### Dashboard и form options (TTL 1 час)

| Ключ | Данные |
|------|--------|
| `dashboard:user:{id}:metrics` | KPI дашборда для пользователя |
| `form-options:deals:clients:user:{id}` | список клиентов для формы Deal (scope по роли) |

### Что НЕ кэшируется

- Paginated index Client / Deal
- Tools: Task, Note, Reminder, CalendarEvent
- Users index

---

## Инвалидация кэша

Принцип: **точечный сброс по ID**, без глобального `flush()`. Это безопасно при одновременной работе нескольких пользователей.

### Client

**Метод:** `CacheInvalidator::forgetClient($client, $previousManagerId?)`

**Сбрасывает:**
- `client:{id}:show`
- `dashboard:user:{manager_id}:metrics`
- `form-options:deals:clients:user:{manager_id}`

При смене менеджера также сбрасываются ключи **предыдущего** менеджера.

**Вызывается из:**
- `CreateClientAction`, `UpdateClientAction`, `RestoreClientAction`
- `ClientService::delete()`
- `ManagerService::assignClient()`

### Deal

**Метод:** `CacheInvalidator::forgetDeal($deal)`

**Сбрасывает:**
- `deal:{id}:show`
- `client:{client_id}:show` (deals вложены в show клиента)
- dashboard и form-options менеджера клиента

**Вызывается из:**
- `CreateDealAction`, `RestoreDealAction`
- `DealService::update()`, `DealService::delete()`

### ClientStatus / DealStatus

**Методы:** `forgetClientStatuses()`, `forgetDealStatuses()`

**Сбрасывает:** все reference-ключи соответствующего справочника.

При update/delete дополнительно:
- `forgetClientsByStatusId()` — show и dashboard затронутых клиентов
- `forgetDealsByStatusId()` — через `forgetDeal()` для каждой сделки

**Вызывается из:** `ClientStatusService`, `DealStatusService`

### Managers

**Метод:** `forgetManagers()`

**Сбрасывает:** `reference:managers:active`

**Вызывается из:** `ManagerService::toggleActive()`, `UserController` (при назначении роли manager)

---

## Роли пользователя в session

Чтобы не обращаться к Spatie/БД на каждый вызов `isAdmin()` / `isHead()` / `isManager()`:

1. **Login** — после успешного входа в `LoginController` вызывается `applyUserRolesToSession()`.
2. **User model** — helpers читают `session('auth.roles')`, fallback на `hasRole()` (консоль, тесты с `actingAs`).
3. **UserController** — после `syncRoles()` вызывается `invalidateUserRoles()`: версия ролей пишется в Redis, session текущего пользователя обновляется сразу.
4. **Middleware `SyncSessionRoles`** — сравнивает `session('auth.roles_version')` с ключом `user:{id}:roles:version`; при расхождении подтягивает актуальные роли из БД.
5. **Spatie Permission cache** (24ч) оставлен как страховка в `config/permission.php`.

---

## Изменённые файлы

### Новые

- `app/Support/Cache/CacheKey.php`
- `app/Services/Cache/ReferenceDataCache.php`
- `app/Services/Cache/CacheInvalidator.php`
- `tests/Unit/Cache/CacheInvalidatorTest.php`
- `tests/Feature/Cache/CacheInvalidationTest.php`

### Обновлённые сервисы

- `app/Services/Client/ClientService.php`
- `app/Services/Deal/DealService.php`
- `app/Services/Dashboard/DashboardService.php`
- `app/Services/Manager/ManagerService.php`
- `app/Services/Settings/ClientStatusService.php`
- `app/Services/Settings/DealStatusService.php`

### Обновлённые Actions

- `app/Actions/Client/CreateClientAction.php`
- `app/Actions/Client/UpdateClientAction.php`
- `app/Actions/Client/RestoreClientAction.php`
- `app/Actions/Deal/CreateDealAction.php`
- `app/Actions/Deal/RestoreDealAction.php`

### Auth / User

- `app/Http/Controllers/Auth/LoginController.php`
- `app/Http/Controllers/User/UserController.php`
- `app/Models/User.php`

### Конфигурация

- `.env.example` — `CACHE_STORE=redis`

---

## Тестирование

### Unit — `tests/Unit/Cache/CacheInvalidatorTest.php`

Проверяет контракт invalidator через `Cache::spy()`:
- корректные ключи при `forgetClient()` (включая previous manager)
- корректные ключи при `forgetDeal()`
- сброс reference-ключей справочников
- `invalidateUserRoles()`

### Feature — `tests/Feature/Cache/CacheInvalidationTest.php`

Проверяет поведение (нет stale data):
- обновление client сбрасывает show-кэш
- обновление deal сбрасывает show родительского client
- изменение ClientStatus обновляет form options
- login сохраняет роли в session

### Запуск

```bash
./vendor/bin/sail artisan test --compact tests/Unit/Cache/
./vendor/bin/sail artisan test --compact tests/Feature/Cache/
```

Результат на момент внедрения: **11 passed**.

---

## Эксплуатация

### Проверка Redis

```bash
./vendor/bin/sail artisan tinker --execute 'echo Illuminate\Support\Facades\Redis::connection()->ping();'
# Ожидается: 1
```

### Ручной сброс всего кэша приложения

```bash
./vendor/bin/sail artisan cache:clear
```

### Переменные окружения

```env
CACHE_STORE=redis
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PORT=6379
```

---

## Ограничения и заметки

1. **Cache tags** не используются — вместо них явный список ключей в `CacheInvalidator`. Это обеспечивает совместимость с `array` driver в тестах.

2. **Serialized Eloquent models** хранятся в кэше show-страниц. После invalidation модель пересобирается из БД с актуальными relations.

3. **Dashboard metrics** кэшируются per-user. Admin/Head видят все данные, Manager — только свои (scope в `buildMetrics()`).

4. При добавлении нового кэшируемого ресурса: добавить ключ в `CacheKey`, чтение в Service, invalidation в `CacheInvalidator` и соответствующий Action/Service write-path.
