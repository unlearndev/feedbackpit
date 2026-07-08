# Changelog

## v1.1 - 2026-07-08

### Features

- Modified the feedback feature.

### Chores

- Added a user-facing release notes step to the release workflow.
- Updated the changelog for the v1.0 release.
- Adjusted the changelog workflow to push its commit with an explicit token, fixed its commit guard to detect a newly created changelog file, granted id-token write permission to the changelog job for the Claude Code action, and re-dispatched the workflow to work around the action's lack of release-event support.

## v1.0 - 2026-07-03

### Features

- Added user registration.
- Added login.
- Added password reset.
- Added account settings.
- Added first and last name to user accounts.
- Added idea submission and idea pages.
- Added voting.
- Added comments.
- Added team member setup.
- Added notification functionality.
- Added notification preferences.
- Added status functionality.
- Added a home page.
- Applied design updates.
- Added a favicon.
- Added emoji reactions, initially behind a Pennant feature flag and later shipped unconditionally after the flag was removed.

### Fixes

- Fixed authentication copy.
- Fixed a toast message and removed on-page validation.

### Chores

- Added a GitHub Actions workflow to run tests on pull requests.
- Added a preflight checklist job to CI and granted it id-token write permission for OIDC.
- Added a QA checklist job to CI after tests pass.
- Added a changelog workflow that writes CHANGELOG.md on release.
- Added a triage workflow.
- Fixed the triage workflow prompt to follow SKILL.md verbatim.
- Added OpenSpec and archived it.
- Installed Fortify and refactored the Fortify integration.
- Refactored API resources.
- Added linting and static analysis.
- Set up the application layout.
- Removed the welcome page.
- Removed the plan.
- Created and updated a demo seeder.
- Generated Wayfinder output.
- Updated the README.
- Fixed up coding standards.
- Added registration and idea page tests and adjusted a failing test.
- Set up the initial project.

