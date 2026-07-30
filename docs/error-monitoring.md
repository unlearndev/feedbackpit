# Error monitoring

FeedbackPit reports unhandled exceptions (and, optionally, performance data) to [Sentry](https://sentry.io) via the `sentry/sentry-laravel` package.

## How it is wired up

`bootstrap/app.php` hands Laravel's exception handler to Sentry:

```php
->withExceptions(function (Exceptions $exceptions): void {
    Integration::handles($exceptions);
})
```

Any exception that reaches the framework handler is therefore captured and sent to Sentry, in addition to Laravel's normal logging and error page behaviour. No application code needs to call Sentry directly.

## Configuration

Settings live in [`config/sentry.php`](../config/sentry.php) and are driven entirely by environment variables. The two that `.env.example` asks for are:

- `SENTRY_LARAVEL_DSN` — the project DSN that tells the SDK where to send events (falls back to `SENTRY_DSN`). Leave it empty and nothing is sent, which is the default for local development.
- `SENTRY_TRACES_SAMPLE_RATE` — the share of requests captured as performance traces. Unset means tracing is off; set e.g. `0.2` to trace 20% of requests.

Other useful defaults from the config file:

- **Error sampling** — `SENTRY_SAMPLE_RATE` defaults to `1.0`, so every captured error is sent.
- **Environment and release** — `SENTRY_ENVIRONMENT` and `SENTRY_RELEASE`. When the environment is left empty, Sentry uses the Laravel environment (`APP_ENV`).
- **PII** — `send_default_pii` is `false`, so user IP addresses and request bodies are not attached to events unless `SENTRY_SEND_DEFAULT_PII=true`.
- **Health checks ignored** — Laravel's `/up` endpoint is listed in `ignore_transactions`, so it never shows up as a transaction.
- **Breadcrumbs** — logs, cache events, SQL queries, queue jobs, commands, HTTP client requests, and notifications are recorded as breadcrumbs. SQL *bindings* are off by default to avoid leaking data into events.
- **Tracing spans** — when tracing is enabled, SQL queries, views, cache and HTTP client calls, queue jobs, and notifications are captured as spans. Redis commands and 404 (unmatched route) transactions are off by default.
- **Profiling** — off unless `SENTRY_PROFILES_SAMPLE_RATE` is set.

Sentry logs (`SENTRY_ENABLE_LOGS`) are disabled by default; metrics (`SENTRY_ENABLE_METRICS`) are enabled.

## Tests

`phpunit.xml` sets `SENTRY_LARAVEL_DSN` to `null` for the test suite, so running tests never sends events to Sentry.
