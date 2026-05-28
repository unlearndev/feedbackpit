## 1. Backend

- [ ] 1.1 Update `AccountSettingsController@update` to forward `$request->input('name')` to the `UpdateUserProfileInformation` action instead of re-passing the existing user name.

## 2. Frontend

- [ ] 2.1 Add `name` to the `useForm` initial state in `resources/js/Pages/Account/Settings.vue`, pre-populated from `usePage().props.auth.user.name`.
- [ ] 2.2 Add an `AppInput` for `name` above the email input, wired to `form.name` and `form.errors.name`, with `autocomplete="name"` and `required`.

## 3. Tests

- [ ] 3.1 Add a feature test at `tests/Feature/Account/UpdateNameTest.php` covering: name updates successfully, empty name is rejected with a validation error, overlong (>255 chars) name is rejected.
- [ ] 3.2 Update existing `tests/Feature/Account/UpdateEmailTest.php` if it asserts on payload shape that no longer matches.

## 4. Verification

- [ ] 4.1 Run `composer lint` and fix any issues.
- [ ] 4.2 Run `npm run lint:fix` and fix any issues.
- [ ] 4.3 Run `composer analyse` and fix any issues.
- [ ] 4.4 Run `composer test` and ensure all tests pass.
- [ ] 4.5 Manually verify in browser: edit name on Account Settings, confirm success flash and that the new name appears wherever the user's name is rendered (e.g. avatar initials, comment author).
