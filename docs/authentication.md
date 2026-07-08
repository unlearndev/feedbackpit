# Authentication

Authentication is powered by [Laravel Fortify](https://laravel.com/docs/fortify). The enabled features are **registration** and **password resets** (`config/fortify.php`). Login is always available; email verification is not enabled.

## Registration

New users register through the `Auth/Register` page. Accounts are created by `App\Actions\Fortify\CreateNewUser`, which validates:

- `first_name` — required, string, max 255.
- `last_name` — required, string, max 255.
- `email` — required, a valid email, max 255, must be unique, and must **not** be a disposable/throwaway address (`indisposable` rule).
- `password` — must satisfy the shared password rules (see `PasswordValidationRules`).

The password is hashed automatically via the model's `hashed` cast. A user has a computed `name` attribute (`first_name` + `last_name`) and an auto-generated avatar from `ui-avatars.com`.

Newly registered users are ordinary members. Team access (`is_team_member`) is not granted through registration — see [Internal team dashboard](internal-dashboard.md).

## Login

Login uses the `Auth/Login` page and Fortify's standard login flow. Routes such as `login` are provided by Fortify (they are referenced by name, e.g. the team middleware redirects unauthenticated users to `route('login')`).

## Password reset

Users who forget their password use the `Auth/ForgotPassword` page to request a reset link and the `Auth/ResetPassword` page to set a new one. The reset itself is handled by `App\Actions\Fortify\ResetUserPassword`.

## Disposable email protection

Both registration and profile email changes reject disposable email domains via the `indisposable` validation rule. The domain list is refreshed weekly by the scheduled `disposable:update` command (`routes/console.php`).

## Shared auth state

The authenticated user is shared with every Inertia page as `auth.user` (via `HandleInertiaRequests`), serialized through `UserResource`. The user's own email address is only exposed to themselves; other users never see it.
