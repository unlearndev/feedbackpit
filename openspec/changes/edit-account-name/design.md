## Context

The Account Settings page (`resources/js/Pages/Account/Settings.vue`) currently exposes an email form and a password form. `AccountSettingsController@update` delegates to Fortify's `UpdateUserProfileInformation` action, which already validates and persists both `name` and `email`. The controller passes the existing `$request->user()->name` unchanged — so the underlying machinery is in place, the only gap is the UI input and the controller wiring.

## Goals / Non-Goals

**Goals:**
- Let an authenticated user edit their `name` from the Account Settings page.
- Reuse the existing Fortify `UpdateUserProfileInformation` action — no parallel validation or persistence path.
- Surface validation errors inline on the name input (per project convention: no banner-style errors).

**Non-Goals:**
- Splitting name into first/last name fields. The `users.name` column stays as-is.
- Admin-side editing of other users' names.
- Audit logging of name changes.
- Changes to how the name is displayed elsewhere (avatars, comments, idea author labels).

## Decisions

### Decision: Keep one combined profile form (name + email), not two separate forms
The existing form already submits to `account.settings.update`, and Fortify's action validates name and email together. Adding `name` to the same `useForm` and submitting both fields in one request keeps the controller, action, and route untouched and avoids a second round-trip for users editing both fields.

**Alternative considered:** A dedicated name form with its own endpoint. Rejected — it would duplicate the Fortify wiring and create a second validation surface for a single text field.

### Decision: Reuse `UpdateUserProfileInformation` unchanged
The action's validation rules (`required`, `string`, `max:255`) and persistence logic already cover the name field. The only code change in the backend is `AccountSettingsController@update` forwarding `$request->input('name')` instead of `$request->user()->name`.

**Alternative considered:** Writing a thin `UpdateName` action. Rejected — the project convention (`agents.md`) explicitly says: "Always reuse existing Fortify actions before writing authentication or profile-related logic in controllers."

### Decision: Pre-populate the input from `usePage().props.auth.user.name`
Same pattern as the existing email field. No extra prop plumbing needed.

## Risks / Trade-offs

- **[Risk]** Forgetting to whitelist `name` in `$request->only(...)` could let unrelated fields leak into the Fortify action. → **Mitigation:** Pass `name` and `email` explicitly as separate keys to the updater (matches the controller's current style and the `agents.md` rule against `$request->all()`).
- **[Risk]** Users could submit an empty name and break avatars / display labels. → **Mitigation:** Fortify's existing `required|string|max:255` validation already enforces non-empty; surfaced inline via the `:error` prop on `AppInput`.
