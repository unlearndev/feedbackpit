# Feature: Idea Detail Page — Stacked PR Plan

## Context

The board (Home.vue) lists ideas but none are clickable. This adds a public detail page for each idea showing the full description, current status, author, and vote count. Upvoting and comments are out of scope (placeholders only).

---

## PR 1: Tests

**Branch:** `idea-detail-tests` off `main`

### New files

| File | Purpose |
|---|---|
| `tests/Feature/Ideas/ViewIdeaDetailTest.php` | Feature tests defining the expected behaviour of the detail page |

### Tests

1. Renders the detail page (GET `/ideas/{id}` returns 200, Inertia component `Ideas/Show`)
2. Includes the idea author name (`idea.user.name`)
3. Includes the full description (`idea.description`)
4. Includes the status (`idea.status`)
5. Includes the vote count (`idea.votes`)
6. Returns 404 for a non-existent idea
7. Accessible to guests (no auth required)

These tests will fail until PR 2 lands — that's intentional.

---

## PR 2: Backend

**Branch:** `idea-detail-backend` off `idea-detail-tests`

### Modified files

| File | Change |
|---|---|
| `routes/web.php` | Add `GET /ideas/{idea}` (public, **after** auth group to avoid shadowing `/ideas/create`) named `ideas.show` |
| `app/Http/Controllers/IdeaController.php` | Add `show(Idea $idea)` — loads `user:id,name`, returns `Ideas/Show` with the idea |

### New files

| File | Purpose |
|---|---|
| `resources/js/Pages/Ideas/Show.vue` | Minimal stub page (just enough for tests to pass — renders the idea data) |

### Controller method

```php
public function show(Idea $idea): Response
{
    $idea->load('user:id,name');

    return inertia('Ideas/Show', [
        'idea' => $idea,
    ]);
}
```

### Route

```php
Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
```

Placed after the auth group so `/ideas/create` matches first.

All PR 1 tests should now pass.

---

## PR 3: Frontend

**Branch:** `idea-detail-frontend` off `idea-detail-backend`

### Modified files

| File | Change |
|---|---|
| `resources/js/Pages/Ideas/Show.vue` | Full page UI (see layout below) |
| `resources/js/Pages/Home.vue` | Wrap idea title in `<a>` linking to `/ideas/${idea.id}` |

### Show.vue layout

- Back link to `/` ("Back to ideas")
- Title (h1), status badge (same pill styling as Home.vue)
- Author name + formatted date
- Vote count display (static box, same style as Home.vue — placeholder for future interactive upvote)
- Full description with `whitespace-pre-line`
- Placeholder section for comments (empty state text)

---

## Verification (after each PR)

```bash
composer lint          # Pint
npm run lint:fix       # ESLint
composer analyse       # Larastan level 5
composer test          # Pest
```
