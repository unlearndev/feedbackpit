## Context

The `users` table currently has a single `name` column populated at registration and (in earlier proposals) intended to be editable from the account settings page. The application surfaces the value in many places: avatars, comment/idea attribution, page headers. Splitting the column touches the schema, two Fortify actions, the `User` model, `UserResource`, registration and account settings views, and the user factory.

A previous OpenSpec change (`name-in-account-settings`, see git history) introduced the `name` field on the account settings page. This change supersedes that decision for the model layer but keeps the same UX surface (Registration + Account Settings) — now each form has two inputs instead of one.

Constraints:
- Existing users have a single `name` value that must be migrated without manual intervention.
- All views currently use `user.name` (e.g. `idea.user.name`, `comment.user.name`, layout avatar alt text). These should keep working without view-by-view edits.
- Conventions in `agents.md` require named routes, API Resources, inline validation errors, and Fortify-action reuse — already in place for this area.

## Goals / Non-Goals

**Goals:**
- Store first and last name as discrete database columns.
- Allow the user to register with and edit first/last name independently.
- Keep `user.name` working in templates by exposing a computed accessor.
- Preserve existing user data via a one-time backfill.

**Non-Goals:**
- Adding middle name, name prefix/suffix, preferred name, or display name fields.
- Internationalization of name ordering (we render as `"{first_name} {last_name}"` everywhere).
- Backwards-compatible JSON shape for any external API (there are no external consumers).
- Requiring last name to be non-empty for users whose legal name is a single word — `last_name` is stored as an empty string in that case, not null.

## Decisions

### 1. Two columns (`first_name`, `last_name`) instead of keeping `name` plus adding new ones

Alternatives considered:
- Keep `name` and add `first_name`/`last_name` alongside it (denormalized).
- Add a single nullable `last_name`, repurpose `name` as `first_name`.

Chosen: drop `name`, add `first_name` and `last_name`. Rationale: avoids three sources of truth for the same data, avoids surprising semantics where `name` is what you registered with but `first_name`/`last_name` is what you edited. The one-time pain of a column rename is worth the long-term clarity.

### 2. `last_name` is `string` not nullable; defaults to empty string on backfill if the existing `name` has no whitespace

Alternative: make `last_name` nullable.

Chosen: not nullable, empty-string default. Rationale: keeps PHP/JS code free of null checks in the `name` accessor and in the Vue templates that interpolate `user.name`. The cost is that a user named "Cher" will store `last_name = ""`, which is harmless.

### 3. Expose `name` as a computed Eloquent accessor

Alternative: update every Vue template and PHP usage of `name`.

Chosen: add a `name` accessor on `User` returning `trim("{$first_name} {$last_name}")`, and expose it via `UserResource` as `'name' => $this->name`. Rationale: every existing reference (`{{ user.name }}`, `urlencode($this->name)` in `avatarUrl()`, `note.user.name`, etc.) keeps working with zero churn. The accessor is the single rendering rule for "full name."

### 4. Backfill via the same migration that adds the columns

Alternative: separate data migration, or a console command.

Chosen: one migration that (a) adds the columns nullable, (b) backfills them by splitting `name` on the first whitespace, (c) makes them non-nullable, (d) drops the old `name` column. Rationale: keeps the deploy atomic and reversible (the `down()` method recreates `name` from `trim("{first_name} {last_name}")`).

### 5. Account settings page becomes the canonical edit surface

The current `AccountSettingsController::update` reads `name` from the user (not the request) and only edits email. We change it to read `first_name` and `last_name` from the request, and update the Settings.vue form to render two inputs. Email continues to be edited from the same form.

## Risks / Trade-offs

- **[Risk]** Backfill misclassifies multi-word first names (e.g. "Mary Anne Smith" → first_name "Mary", last_name "Anne Smith"). → Mitigation: this is a best-effort one-time split; users can correct via account settings. Document the rule in the migration.
- **[Risk]** Code or tests reference `User::$name` directly as an attribute (e.g. `$user->name = 'x'`). After the migration, writing to `name` becomes a no-op because it is an accessor, not a column. → Mitigation: grep for `->name =` and `'name' =>` assignments on User in app/ and tests/; update them to write `first_name`/`last_name`. Factory must be updated to generate both columns.
- **[Trade-off]** The accessor returns `trim(...)`, so a user with only a first name renders as `"Cher"` (no trailing space) — but sorting/searching on `last_name` alone will still return the empty-string row. Acceptable.
- **[Risk]** Existing tests that assert against `name` in JSON responses or DB state will fail. → Mitigation: update assertions to use the new fields or the accessor as appropriate. `composer test` is part of the verification checklist.

## Migration Plan

1. Ship the migration in a single deploy. It runs `up()` which adds nullable columns, backfills from `name`, enforces non-null, drops `name`.
2. Rollback (`down()`) re-adds `name`, fills it from `trim("{first_name} {last_name}")`, drops the new columns. Safe to run.
3. No feature flag — the change is atomic and the surface area is small enough to deploy in one go.
