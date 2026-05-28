## ADDED Requirements

### Requirement: Authenticated user can edit their display name
The Account Settings page SHALL provide a `name` input that is pre-populated with the authenticated user's current name and that, on submission, updates the `users.name` column for that user.

#### Scenario: Name is updated successfully
- **WHEN** an authenticated user submits the Account Settings form with a new, valid name
- **THEN** the system persists the new name to the user's record
- **AND** the system redirects back to the Account Settings page with a success flash message

#### Scenario: Name input is pre-populated on page load
- **WHEN** an authenticated user opens the Account Settings page
- **THEN** the name input displays their current name as its initial value

### Requirement: Name input is validated
The system SHALL validate that the submitted name is a non-empty string of at most 255 characters before persisting any change to the user record.

#### Scenario: Empty name is rejected
- **WHEN** an authenticated user submits the Account Settings form with an empty name
- **THEN** the system does not modify the user record
- **AND** an inline validation error is shown on the name input

#### Scenario: Overlong name is rejected
- **WHEN** an authenticated user submits the Account Settings form with a name longer than 255 characters
- **THEN** the system does not modify the user record
- **AND** an inline validation error is shown on the name input

### Requirement: Name editing reuses the Fortify profile-information action
The controller handling the Account Settings update SHALL delegate validation and persistence of the `name` field to the existing `UpdateUserProfileInformation` Fortify action rather than duplicating that logic.

#### Scenario: Update is routed through the Fortify action
- **WHEN** the Account Settings update endpoint is called with a `name` value
- **THEN** the controller passes that `name` value to the `UpdateUserProfileInformation` action
- **AND** no parallel validation or persistence code path exists for the name field in the controller
