# Account settings

Signed-in users manage their account from the `Account/Settings` page. All account routes are behind the `auth` middleware.

## Profile information

`PUT /account/settings` (`account.settings.update`) updates the user's profile. It delegates to the Fortify action `UpdateUserProfileInformation`, passing only `first_name`, `last_name`, and `email`.

Validation:

- `first_name` — required, string, max 255.
- `last_name` — required, string, max 255.
- `email` — required, valid email, max 255, unique (ignoring the current user), and not a disposable address.

On success the user is redirected back to the settings page with the flash message "Your changes have been saved."

## Password

`PUT /account/password` (`account.password.update`) changes the password via the Fortify action `UpdateUserPassword`, passing `current_password`, `password`, and `password_confirmation`. The current password must be correct and the new password must satisfy the shared password rules.

On success the user is redirected back with "Your password has been updated."

## Notification preferences

The account area also includes a notification-preferences page for managing which ideas the user follows. That is documented separately in [Subscriptions & email notifications](notifications.md).
