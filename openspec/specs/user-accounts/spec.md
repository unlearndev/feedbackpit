# user-accounts Specification

## Purpose

Defines how user account profile data is stored, validated, displayed, and edited across registration, account settings, and serialized resources.

## Requirements

### Requirement: User profile stores first and last name as separate fields

The system SHALL store every user's name as two distinct, non-nullable string columns: `first_name` and `last_name`. The system SHALL NOT retain a combined `name` column on the `users` table.

#### Scenario: Schema exposes two name columns

- **WHEN** the `users` table schema is inspected after migrations run
- **THEN** it has `first_name` and `last_name` columns of type `string`, both not nullable
- **AND** it does not have a `name` column

#### Scenario: User can be persisted with an empty last name

- **WHEN** a user is created with `first_name = "Cher"` and `last_name = ""`
- **THEN** the row persists successfully

### Requirement: Full name is exposed as a computed accessor

The system SHALL expose `User::$name` as a read-only accessor that returns the user's full name as `trim("{first_name} {last_name}")`. The accessor SHALL be available wherever the `User` model is rendered, including inside API Resources and Blade/Inertia templates.

#### Scenario: Full name composes first and last with a single space

- **WHEN** a user has `first_name = "Ada"` and `last_name = "Lovelace"`
- **THEN** `$user->name` returns `"Ada Lovelace"`

#### Scenario: Full name trims when last name is empty

- **WHEN** a user has `first_name = "Cher"` and `last_name = ""`
- **THEN** `$user->name` returns `"Cher"` with no trailing whitespace

#### Scenario: Avatar URL uses the full-name accessor

- **WHEN** `User::avatarUrl()` is called for a user with `first_name = "Ada"` and `last_name = "Lovelace"`
- **THEN** the returned URL's `name` query parameter is the URL-encoded value `"Ada Lovelace"`

### Requirement: Registration collects first and last name

The system SHALL require both first name and last name as separate, required, non-empty string fields during user registration. The system SHALL validate each field as `required|string|max:255`.

#### Scenario: Successful registration with both names

- **WHEN** a guest submits the registration form with `first_name`, `last_name`, `email`, `password`, and `password_confirmation` all valid
- **THEN** a new user is created with the submitted `first_name` and `last_name`
- **AND** the user is logged in and redirected per Fortify defaults

#### Scenario: Missing last name fails validation

- **WHEN** a guest submits the registration form with `first_name = "Ada"` and `last_name = ""`
- **THEN** validation fails with an error on the `last_name` field
- **AND** no user is created

#### Scenario: Missing first name fails validation

- **WHEN** a guest submits the registration form with `first_name = ""` and `last_name = "Lovelace"`
- **THEN** validation fails with an error on the `first_name` field
- **AND** no user is created

### Requirement: Account settings allow editing first and last name

The system SHALL allow an authenticated user to edit their own `first_name` and `last_name` from the account settings page. The system SHALL persist the submitted values using the existing Fortify `UpdatesUserProfileInformation` action.

#### Scenario: Successful update of first and last name

- **WHEN** an authenticated user submits the account settings form with new `first_name`, `last_name`, and unchanged `email`
- **THEN** the user's record is updated with the new values
- **AND** the user is redirected to the account settings page with a success flash message

#### Scenario: Empty first name is rejected

- **WHEN** an authenticated user submits the account settings form with `first_name = ""`
- **THEN** validation fails with an error on the `first_name` field
- **AND** the user's record is unchanged

#### Scenario: Empty last name is rejected

- **WHEN** an authenticated user submits the account settings form with `last_name = ""`
- **THEN** validation fails with an error on the `last_name` field
- **AND** the user's record is unchanged

### Requirement: UserResource exposes first name, last name, and the computed full name

The `UserResource` SHALL include `first_name`, `last_name`, and `name` in its serialized output. The `name` field SHALL be the value of the `User::$name` accessor.

#### Scenario: Resource serializes all three name fields

- **WHEN** a `UserResource` is rendered for a user with `first_name = "Ada"` and `last_name = "Lovelace"`
- **THEN** the resulting array contains `first_name = "Ada"`, `last_name = "Lovelace"`, and `name = "Ada Lovelace"`

### Requirement: Existing users are backfilled by splitting the legacy name on the first whitespace

The migration that introduces `first_name` and `last_name` SHALL backfill every existing user row by splitting the legacy `name` value on its first whitespace character: `first_name` receives the substring before the split, `last_name` receives everything after. If the legacy `name` contains no whitespace, `first_name` receives the whole value and `last_name` is set to the empty string. The migration SHALL drop the `name` column only after backfill completes.

#### Scenario: Two-word legacy name is split as expected

- **WHEN** the migration runs against a row with `name = "Ada Lovelace"`
- **THEN** the row ends with `first_name = "Ada"` and `last_name = "Lovelace"`

#### Scenario: Multi-word legacy name keeps everything after the first space as last name

- **WHEN** the migration runs against a row with `name = "Mary Anne Smith"`
- **THEN** the row ends with `first_name = "Mary"` and `last_name = "Anne Smith"`

#### Scenario: Single-word legacy name leaves last name empty

- **WHEN** the migration runs against a row with `name = "Cher"`
- **THEN** the row ends with `first_name = "Cher"` and `last_name = ""`

#### Scenario: Rollback rebuilds the name column from first and last

- **WHEN** the migration's `down()` method runs
- **THEN** the `users` table regains a `name` column populated with `trim("{first_name} {last_name}")` for every row
- **AND** the `first_name` and `last_name` columns are dropped
