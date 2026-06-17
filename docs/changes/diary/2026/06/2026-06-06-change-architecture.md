# Дневник изменений

## 14:00 (Europe/Kyiv) refactor[controller.tools,controller.settings,controller.manager,request.tools,service.tools] — MRSRB-рефакторинг Tools, Settings, Manager
**Entry ID:** 01JWREFACTOR20260606
**Agent:** composer-2.5-fast
**Дата:** 2026-06-06
**Ветка:** change_architecture

### Файлы
- `app/Http/Controllers/Web/Tools/*` (+4 контроллера)
- `app/Http/Controllers/Web/Settings/*` (+3 контроллера)
- `app/Http/Controllers/Web/Manager/ManagerController.php` (+1)
- `app/Http/Requests/{Task,Reminder,CalendarEvent,Note,Manager,Settings}/*` (+18)
- `app/Services/{Task,Reminder,CalendarEvent,Note,Settings,Manager}/*` (+8)
- `app/Actions/{Task,Reminder,CalendarEvent}/*` (+6)
- `app/ViewModels/{Task,Reminder,CalendarEvent,Note,Settings,Manager}/*` (+9)
- `routes/web.php` (обновлены импорты)
- `database/factories/*` (+7 фабрик)
- `tests/Feature/{Tools,Settings,Manager}/*` (+7 тестов)
- `tests/Concerns/ActsAsRoles.php`, `tests/CreatesApplication.php`

### Что сделано
Контроллеры Tools (Task, Reminder, Calendar, Note), Settings (ClientStatus, DealStatus, SystemSettings) и Manager перенесены в `Web/` и приведены к MRSRB: валидация в Form Request, бизнес-логика в Service/Action, данные для Blade — в ViewModel. Удалены inline-validate и Eloquent из контроллеров. Добавлены feature-тесты (25 passed) и фабрики моделей.

### Почему
Промпт refactoring_tools_settings_user.md: раздутые контроллеры не соответствовали SOLID и SKILLS.md; эталон — ClientController.

### Влияние
- **БД:** N/A
- **API:** N/A (контракты маршрутов и JSON `{saved: true}` / `pending` сохранены)
- **Производительность:** N/A

### Проверено
- Тесты: новые (25 passed в Tools/Settings/Manager)
- Линтер: pint ok

### Follow-up
- [ ] N/A
