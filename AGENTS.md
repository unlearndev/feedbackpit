# Development philosophy
- Prefer simple solutions over clever ones.
- Write code that is clear and self-explanatory.
- Build with the long term in mind.

# Stack
- PHP/Laravel
- Inertia.js
- Vue.js
- Tailwind CSS

# Conventions
- Always use the `inertia()` helper instead of `Inertia::render()`.
- Always use named routes. Never use hardcoded paths in `redirect()` or elsewhere — use `route('name')` instead.
- Never use `$request->all()`. Only pass the specific fields needed (e.g. `$request->only([...])` or explicit keys).
- Always reuse existing Fortify actions (in `app/Actions/Fortify/`) before writing authentication or profile-related logic in controllers.
- Always use API Resources (`app/Http/Resources/`) when passing data to Inertia views. Never pass raw models or collections directly. Only include the fields the frontend actually needs.
- Always use controllers for route handlers. Never use closures in route files.
- Never use standalone error/success banners on pages. Use inline validation errors via the `:error` prop on form inputs, and the global `FlashMessage` component for success messages.

# Verification
After making changes, always run the following checks and fix any issues before considering work complete:

1. **PHP lint**: `composer lint` (Pint)
2. **JS lint**: `npm run lint:fix` (ESLint)
3. **Static analysis**: `composer analyse` (PHPStan/Larastan)
4. **Tests**: `composer test` (Pest)

