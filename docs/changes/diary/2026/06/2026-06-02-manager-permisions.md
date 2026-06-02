# Дневник изменений

## 19:56 (Europe/Kyiv) feat[policy.client-deal,controller.client,phase6-settings,layout] — Права менеджера и руководителя
**Entry ID:** 01JWMANPERM20260602
**Agent:** composer-2.5-fast
**Дата:** 2026-06-02
**Ветка:** manager_permisions

### Файлы
- `app/Policies/ClientPolicy.php` (+1 −1)
- `app/Http/Controllers/Client/ClientController.php` (+4 −0)
- `app/Http/Requests/Settings/StatusRequest.php` (+3 −1)
- `routes/web.php` (+18 −16)
- `resources/views/components/layouts/app.blade.php` (+6 −2)

### Что сделано
Менеджер может создавать клиентов: `ClientPolicy::create` разрешён для всех активных пользователей, при сохранении менеджеру автоматически назначается `manager_id`. Руководитель получил CRUD справочников статусов клиентов и сделок: маршруты вынесены в группу `role:admin|head`, обновлены `StatusRequest` и пункты сайдбара (добавлена ссылка на статусы сделок).

### Почему
Требование промпта change_permission.md: менеджер добавляет клиентов, руководитель управляет статусами.

### Влияние
- **БД:** N/A
- **API:** N/A
- **Производительность:** N/A

### Проверено
- Тесты: N/A (нет существующих тестов политик)
- Линтер: todo

### Follow-up
- [ ] N/A
