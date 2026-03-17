# Development philosophy
- Prefer simple solutions over clever ones.
- Write code that is clear and self-explanatory.
- Build with the long term in mind.

# Stack
- PHP/Laravel
- Inertia.js
- Vue.js
- Tailwind CSS

# Fortify
- Always reuse existing Fortify actions (in `app/Actions/Fortify/`) before writing authentication or profile-related logic in controllers.

# Verification
After making changes, always run the following checks and fix any issues before considering work complete:

1. **PHP lint**: `composer lint` (Pint)
2. **JS lint**: `npm run lint:fix` (ESLint)
3. **Static analysis**: `composer analyse` (PHPStan/Larastan)
4. **Tests**: `composer test` (Pest)

