## Why

The users table stores a single `name` column, which lumps the user's first and last name together. Storing them as separate fields gives us flexibility for personalization (e.g. greeting by first name only), sorting/searching by last name, and matches the structure most external services (email, billing, CRM) expect.

## What Changes

- **BREAKING**: Replace the `name` column on `users` with `first_name` and `last_name` columns.
- Update the registration form to collect first name and last name as separate inputs.
- Update the account settings page to expose first name and last name (currently it does not edit the name at all).
- Update `CreateNewUser` and `UpdateUserProfileInformation` Fortify actions to validate and persist the two new fields.
- Update `User` model fillables, the `avatarUrl()` helper, and add a `name` accessor that returns `"{first_name} {last_name}"` so display code does not need to change.
- Update `UserResource` to expose `first_name`, `last_name`, and the computed `name` accessor.
- Backfill existing rows by splitting the current `name` value on the first whitespace into `first_name` (everything before) and `last_name` (everything after, or empty string if no whitespace).

## Capabilities

### New Capabilities
- `user-accounts`: Captures the user account profile data model (first/last name, email) and the registration + account settings surfaces that read and write it. No prior spec exists for this capability.

### Modified Capabilities
<!-- None — the user-accounts capability is being specified for the first time. -->


## Impact

- **Database**: `users` table — drop `name`, add `first_name` and `last_name` (both `string`, not nullable). Data migration required to backfill from existing `name` values.
- **Models**: `App\Models\User` — fillables, `avatarUrl()`, factory.
- **Fortify actions**: `CreateNewUser`, `UpdateUserProfileInformation`.
- **Controllers**: `AccountSettingsController::update` — pass through both new fields instead of `name`.
- **Resources**: `App\Http\Resources\UserResource`.
- **Views**: `resources/js/Pages/Auth/Register.vue`, `resources/js/Pages/Account/Settings.vue`.
- **Tests**: registration tests, account settings tests, any user factory usage.
- **No external API consumers** today, so no backwards-compatibility shim is required.
