# FeedbackPit

FeedbackPit is a suggestion tracking application and the live project powering all workflows across [Unlearn](https://unlearn.dev).

## Stack

- **Backend:** PHP 8.2+ / Laravel 12
- **Frontend:** Vue 3 with Inertia.js
- **Styling:** Tailwind CSS 4
- **Build:** Vite
- **Testing:** Pest
- **Static Analysis:** Larastan

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm

### Setup

```bash
composer setup
```

This single command will:

1. Install PHP dependencies
2. Copy `.env.example` to `.env` (if needed)
3. Generate an application key
4. Run database migrations
5. Install Node dependencies
6. Build frontend assets

### Development

```bash
composer dev
```

This starts the Laravel dev server, queue worker, log tail, and Vite dev server concurrently.

## Linting & Testing

```bash
composer lint      # PHP formatting (Pint)
npm run lint:fix   # JS/Vue linting (ESLint)
composer analyse   # Static analysis (Larastan)
composer test      # Tests (Pest)
```

## Login Flow

Login is handled by Laravel Fortify. This is the path a sign-in takes from the form to the redirect.

```text
╭─ 👆 CLICK ──────────────────────────────────────────
│  "Sign In" posts email + password
│  › useForm() submit(), password reset onFinish
│  resources/js/pages/Auth/Login.vue:13
╰──────┬─────────────────────────────────────────────
       │  POST /login {email, password} · login.store
       ▼
╭─ 🔒 GUARD ──────────────────────────────────────────
│  Guests only, 5 tries a minute per email + IP
│  › guest:web, throttle:login (fortify.limiters)
│  app/Providers/FortifyServiceProvider.php:43
╰──────┬─────────────────────────────────────────────
       │
       ├──✗──▶ 6th try in a minute: 429 Too Many
       │       app/Providers/FortifyServiceProvider.php:46
       ▼ ✓
┌┄ 📦 VENDOR · laravel/fortify ┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄
┆  validate → lowercase email → guard->attempt()
┆  › LoginRequest → CanonicalizeUsername →
┆    AttemptToAuthenticate; remember always false
┆  Http/Controllers/AuthenticatedSessionController.php:58
└┄┄┄┄┄┄┬┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄
       │  credentials {email, password}
       ▼
╭─ 💾 DATABASE ───────────────────────────────────────
│  Find the user by email, check the password hash
│  › eloquent provider, App\Models\User
│  › users.email, users.password
│  config/auth.php:65
╰──────┬─────────────────────────────────────────────
       │
       ├──✗──▶ no match: auth.failed on email,
       │       shown under email field (Login.vue:32)
       │       Actions/AttemptToAuthenticate.php:101
       ▼ ✓
┌┄ 📦 VENDOR · laravel/fortify ┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄
┆  regenerate session → clear rate limit
┆  Actions/PrepareAuthenticatedSession.php:37
└┄┄┄┄┄┄┬┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄
       ▼
╭─ 🏁 RESPONSE ───────────────────────────────────────
│  Redirect to intended page, else /dashboard
│  › 302 from LoginResponse, fortify.redirects.login
│  config/fortify.php:79
╰────────────────────────────────────────────────────
```

_╭─ app code · ┌┄ vendor (paths relative to `vendor/laravel/fortify/src/`) · ✗ failure branch · ✓ main path_
