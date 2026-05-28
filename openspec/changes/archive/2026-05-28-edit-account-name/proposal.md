## Why

Users can update their email and password in Account Settings, but the name field — which appears throughout the app (avatars, comments, idea author labels) — is fixed at registration with no way to change it. Users who mistyped their name at signup or want to update how they're identified have no self-service option.

## What Changes

- Add a `name` input field to the Account Settings page, pre-populated with the user's current name.
- Wire the existing Fortify `UpdateUserProfileInformation` action to receive the submitted name (the action already validates and persists `name`; the controller currently passes the unchanged user name).
- Update the `AccountSettingsController@update` to forward `name` from the request instead of re-passing the existing value.

## Capabilities

### New Capabilities
- `account-settings`: Self-service editing of the authenticated user's profile fields (email, name) and password from the account settings page.

### Modified Capabilities
<!-- None — no existing specs in openspec/specs/. -->

## Impact

- `resources/js/Pages/Account/Settings.vue` — add name input to the existing profile form.
- `app/Http/Controllers/AccountSettingsController.php` — pass submitted `name` to the Fortify updater.
- `tests/Feature/Account/` — add coverage for updating name (validation + happy path).
- No database, route, or API contract changes; `users.name` column and the Fortify action already support this.
