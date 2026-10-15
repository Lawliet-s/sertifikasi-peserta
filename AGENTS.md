# AGENTS.md

## Tech Stack & Constraints
- PHP 8.2 compatible (Laravel 11/12).
- Database: MySQL `sertifikasi-peserta` via Laragon (DB name with hyphen: always backtick if raw SQL, use Eloquent/Query Builder).
- Frontend: Blade + Tailwind CSS (dark mode supported via `dark:` class and `localStorage`). No emojis as icons (use Lucide / Font Awesome).
- Language: Indonesian for UI/messages, brief Indonesian comments where necessary.

## Commands
- **Dev Server**: `composer dev`
- **Tests**: `composer test` or `php artisan test`
- **Linter**: `vendor/bin/pint`

## Architecture Rules
- Follow MVC strictly. Thin controllers, Form Requests for validation, resource controllers with route-model binding.
- Restrict foreign key deletion (`restrictOnDelete()`).
- Eager load relations (`with(...)`) to prevent N+1 issues.
- Refer to `GEMINI.md` for complete domain specifications.
