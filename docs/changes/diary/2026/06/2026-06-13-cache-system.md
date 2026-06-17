# Дневник изменений

## 12:00 (Europe/Kyiv) feat[service.cache,config.cache,auth,model.user] — Система кэширования CRM на Redis
**Entry ID:** 01JWCACHESYSTEM20260613
**Agent:** composer-2.5-fast
**Дата:** 2026-06-13
**Ветка:** change_architecture

### Файлы
- `app/Support/Cache/CacheKey.php` (+70 −0)
- `app/Services/Cache/ReferenceDataCache.php` (+95 −0)
- `app/Services/Cache/CacheInvalidator.php` (+105 −0)
- `app/Services/Client/ClientService.php` (+20 −8)
- `app/Services/Deal/DealService.php` (+25 −10)
- `app/Services/Dashboard/DashboardService.php` (+30 −15)
- `app/Services/Manager/ManagerService.php` (+15 −5)
- `app/Services/Settings/ClientStatusService.php` (+20 −5)
- `app/Services/Settings/DealStatusService.php` (+20 −5)
- `app/Actions/Client/*` (+15 −0)
- `app/Actions/Deal/*` (+12 −0)
- `app/Http/Controllers/Auth/LoginController.php` (+2 −0)
- `app/Http/Controllers/User/UserController.php` (+10 −0)
- `app/Models/User.php` (+12 −3)
- `.env.example` (+1 −1)
- `tests/Unit/Cache/CacheInvalidatorTest.php` (+110 −0)
- `tests/Feature/Cache/CacheInvalidationTest.php` (+95 −0)

### Что сделано
Внедрена система кэширования на Redis: справочники (ClientStatus, DealStatus, менеджеры), show Client/Deal и метрики dashboard кэшируются через `Cache::remember`. Точечная инвалидация по ID сущностей и связанным структурам (Client → Deal → dashboard менеджера) через `CacheInvalidator`. Роли пользователя кэшируются в session при login; helpers `isAdmin/isHead/isManager` читают session с fallback на Spatie.

### Почему
Промпт cache_system: снизить нагрузку на БД при одновременной работе нескольких пользователей; справочники и show-страницы запрашиваются на каждый HTTP-запрос.

### Влияние
- **БД:** меньше повторных SELECT для справочников, show и dashboard
- **API:** N/A
- **Производительность:** `CACHE_STORE=redis`, TTL entity/dashboard 1 час, справочники — rememberForever + инвалидация по событию

### Проверено
- Тесты: новые (11 passed в Unit/Feature Cache)
- Линтер: pint ok

### Follow-up
- [ ] N/A

## 14:30 (Europe/Kyiv) fix[service.cache,auth,middleware.sync-session-roles] — Сброс кеша ролей при изменении без перелогина
**Entry ID:** 01JWROLESINVALID20260613
**Agent:** composer-2.5-fast
**Дата:** 2026-06-13
**Ветка:** change_architecture

### Файлы
- `app/Support/Cache/CacheKey.php` (+5 −0)
- `app/Services/Cache/CacheInvalidator.php` (+20 −5)
- `app/Http/Middleware/SyncSessionRoles.php` (+35 −0)
- `bootstrap/app.php` (+1 −0)
- `app/Http/Controllers/Auth/LoginController.php` (+8 −2)
- `app/Http/Controllers/User/UserController.php` (+1 −1)
- `tests/Unit/Cache/CacheInvalidatorTest.php` (+15 −3)
- `tests/Feature/Cache/CacheInvalidationTest.php` (+25 −0)
- `docs/cache-system.md` (обновлена секция ролей)

### Что сделано
При изменении роли через UserController вызывается `invalidateUserRoles()`: в Redis сохраняется версия `user:{id}:roles:version`. Middleware `SyncSessionRoles` на следующем запросе пользователя синхронизирует session с БД — новая роль применяется без перелогина.

### Почему
Session-кеш ролей не обновлялся при смене роли администратором для уже залогиненного пользователя.

### Влияние
- **БД:** один запрос ролей Spatie только при расхождении версии
- **API:** N/A
- **Производительность:** минимальный overhead middleware (чтение одного ключа Redis)

### Проверено
- Тесты: обновлены (Unit + Feature Cache)
- Линтер: pint ok

### Follow-up
- [ ] N/A

## 15:30 (Europe/Kyiv) revert[service.cache] — Откат TTL для user:{id}:roles:version
**Entry ID:** 01JWROLESVERSIONTTLREVERT20260613
**Agent:** composer-2.5-fast
**Дата:** 2026-06-13
**Ветка:** change_architecture

### Файлы
- `app/Support/Cache/CacheKey.php` (−1)
- `app/Services/Cache/CacheInvalidator.php` (+1 −4)
- `docs/cache-system.md` (откат упоминания TTL)

### Что сделано
Откат TTL: ключ `user:{id}:roles:version` снова записывается через `Cache::forever()`, константа `USER_ROLES_VERSION_TTL` удалена.

### Почему
Запрос на откат реализации TTL для версий ролей.

### Влияние
- **БД:** N/A
- **API:** N/A
- **Производительность:** маркер invalidation ролей хранится в Redis без expiry

### Проверено
- Тесты: Unit CacheInvalidator — ok
- Линтер: pint ok

### Follow-up
- [ ] N/A
