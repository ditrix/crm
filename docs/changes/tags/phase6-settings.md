# Tag: Phase 6 — System Settings & Directories

**Date:** 2026-05-31
**Entry ID:** 01JWG5CRM2026PHASE6

## Scope
- SystemSettingsController (app name, default locale → .env)
- ClientStatusController (CRUD + soft delete + restore)
- DealStatusController (CRUD + soft delete + restore)
- StatusRequest FormRequest (admin only)
- Settings Blade views (system, client-statuses, deal-statuses)
- Routes /settings/* (role:admin middleware)
- 2026-06-02 — Статусы: маршруты и StatusRequest для admin|head → [../../diary/2026/06/2026-06-02-manager-permisions.md#01JWMANPERM20260602]
- 2026-06-06 — MRSRB-рефакторинг Settings: Web/Settings, StatusService, SystemSettingsService → [../../diary/2026/06/2026-06-06-change-architecture.md#01JWREFACTOR20260606]
- Sidebar: real routes replacing stubs
- Localization keys (en/ua/ru)
