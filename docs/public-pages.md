# Public pages

These pages are reachable without signing in.

## Landing page

`GET /` (`landing`) renders the `Landing` page — the marketing/home page shown to visitors.

## About page

`GET /about` (`about`) renders the static `About` page.

## Dashboard

`GET /dashboard` (`dashboard`) renders the `Dashboard` page, listing every idea newest first with its author, votes, and subscriber data (serialized by `IdeaResource`).

The route is not behind auth middleware, so the dashboard is viewable by anyone. Signed-in users additionally see per-idea state such as whether they have voted or can edit each idea. Submitting, editing, or deleting feedback still requires signing in — see [Feedback (ideas)](feedback.md).
