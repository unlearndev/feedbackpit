# FeedbackPit

FeedbackPit is a suggestion tracking application and the live project powering all workflows across [Unlearn](https://unlearn.dev).

## Stack

- **Backend:** PHP 8.2+ / Laravel 12
- **Frontend:** Vue 3 with Inertia.js
- **Styling:** Tailwind CSS 4
- **Build:** Vite
- **Testing:** Pest
- **Static Analysis:** Larastan

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm

### Setup

```bash
composer setup
```

This single command will:

1. Install PHP dependencies
2. Copy `.env.example` to `.env` (if needed)
3. Generate an application key
4. Run database migrations
5. Install Node dependencies
6. Build frontend assets

### Development

```bash
composer dev
```

This starts the Laravel dev server, queue worker, log tail, and Vite dev server concurrently.

## Linting & Testing

```bash
composer lint      # PHP formatting (Pint)
npm run lint:fix   # JS/Vue linting (ESLint)
composer analyse   # Static analysis (Larastan)
composer test      # Tests (Pest)
```
