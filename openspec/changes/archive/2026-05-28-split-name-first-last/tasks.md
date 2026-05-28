## 1. Database

- [x] 1.1 Create migration `split_name_into_first_and_last_on_users_table` that adds `first_name` and `last_name` as nullable strings, backfills them by splitting `name` on the first whitespace (single-word names → `last_name = ""`), enforces non-nullable, then drops `name`.
- [x] 1.2 Implement `down()` to recreate `name` (string, not nullable), backfill from `trim("{first_name} {last_name}")`, then drop the new columns.
- [x] 1.3 Run the migration locally and verify schema matches the spec (two new columns present, `name` gone).

## 2. Model + Factory

- [x] 2.1 Update `App\Models\User::$fillable` — remove `name`, add `first_name` and `last_name`.
- [x] 2.2 Add a `name` accessor (`Attribute::make(get: fn () => trim("{$this->first_name} {$this->last_name}"))`) on `User`.
- [x] 2.3 Leave `User::avatarUrl()` untouched — it already reads `$this->name`, which now comes from the accessor.
- [x] 2.4 Update `database/factories/UserFactory.php` to generate `first_name` and `last_name` using `fake()->firstName()` and `fake()->lastName()` instead of `name`.

## 3. Fortify Actions

- [x] 3.1 Update `App\Actions\Fortify\CreateNewUser`: replace the `name` validation rule with `first_name` and `last_name` (each `required|string|max:255`); persist both fields on `User::create()`.
- [x] 3.2 Update `App\Actions\Fortify\UpdateUserProfileInformation`: replace the `name` rule and the persisted fields with `first_name` and `last_name` in both the verified and unverified branches.

## 4. Controller

- [x] 4.1 Update `App\Http\Controllers\AccountSettingsController::update` to pass `first_name` and `last_name` (read from the request via `$request->only([...])`) plus `email` into `UpdatesUserProfileInformation::update`. Continue using the named route `account.settings.edit` for the redirect.

## 5. API Resource

- [x] 5.1 Update `App\Http\Resources\UserResource::toArray` to expose `first_name`, `last_name`, and `name` (the accessor). Keep `email`, `is_team_member`, `avatar_url` unchanged.

## 6. Frontend — Registration

- [x] 6.1 Update `resources/js/Pages/Auth/Register.vue`: replace the single `name` field on the `useForm` object with `first_name` and `last_name`; render two `AppInput` components with appropriate labels, `autocomplete="given-name"` / `autocomplete="family-name"`, and `:error` bindings.

## 7. Frontend — Account Settings

- [x] 7.1 Update `resources/js/Pages/Account/Settings.vue`: extend `useForm` with `first_name` and `last_name` seeded from `usePage().props.auth.user`; render two new `AppInput` components above the email field, each with inline `:error` bindings.

## 8. Tests

- [x] 8.1 Update any user factory usage in `database/seeders/` and `tests/` that explicitly sets `name`.
- [x] 8.2 Update registration tests to submit `first_name` and `last_name` and assert both are persisted.
- [x] 8.3 Add account-settings tests covering: successful update of both names, empty-first-name rejection, empty-last-name rejection.
- [x] 8.4 Add a migration test (or assertion in an existing seeder/factory test) that exercises the backfill rule for two-word, multi-word, and single-word legacy names.

## 9. Verification

- [x] 9.1 Run `composer lint` and fix any issues.
- [x] 9.2 Run `npm run lint:fix` and fix any issues.
- [x] 9.3 Run `composer analyse` and fix any issues.
- [x] 9.4 Run `composer test` and ensure the full suite passes.
