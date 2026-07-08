# FeedbackPit Documentation

FeedbackPit is a suggestion-tracking application where users submit feedback ("ideas"), vote and react to them, discuss them in comments, and follow their progress as the team moves them through a status pipeline.

These pages describe each user-facing feature and how it works, grounded in the application code.

## Features

- [Authentication](authentication.md) — registration, login, and password resets.
- [Account settings](account-settings.md) — updating profile details and password.
- [Feedback (ideas)](feedback.md) — submitting, viewing, editing, and deleting feedback.
- [Voting](voting.md) — upvoting ideas.
- [Reactions](reactions.md) — emoji reactions on ideas.
- [Comments](comments.md) — public discussion on ideas.
- [Subscriptions & email notifications](notifications.md) — following ideas and receiving updates.
- [Internal team dashboard](internal-dashboard.md) — team-only triage, status changes, and internal notes.
- [Public pages](public-pages.md) — landing page, about page, and the shared dashboard.
- [Changelog & release notes](changelog.md) — how release notes are generated.

## Roles

There are two kinds of users:

- **Members** — any registered user. They can submit feedback, vote, react, and comment.
- **Team members** — users with `is_team_member` set to `true`. In addition to everything a member can do, they have access to the internal dashboard where they manage status and post internal notes. See [Internal team dashboard](internal-dashboard.md).
