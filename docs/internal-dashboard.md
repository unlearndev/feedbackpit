# Internal team dashboard

The internal dashboard is a team-only area for triaging feedback, changing status, and keeping private notes. All routes live under the `/internal` prefix and the `internal.` route-name group.

## Who can access it

Access is gated by the `auth` and `team` middleware. The `team` middleware (`EnsureTeamMember`):

- Redirects unauthenticated visitors to the login page.
- Aborts with **403** for signed-in users who are not team members.

A user is a team member when `is_team_member` is `true`. This flag is not exposed through registration or account settings — it is set out of band (e.g. via seeder or database).

## Idea list

`GET /internal` (`internal.ideas.index`) renders `Internal/Ideas/Index` with every idea, newest first, including author, votes, subscribers, and a count of **public** comments.

## Idea detail

`GET /internal/ideas/{idea}` (`internal.ideas.show`) renders `Internal/Ideas/Show`. Unlike the public idea page, it loads the idea's full status-update history and separates comments into two threads:

- **Public comments** (`is_internal = false`).
- **Internal comments / notes** (`is_internal = true`).

## Status pipeline

Ideas move through the `IdeaStatus` enum:

| Value           | Label        |
| --------------- | ------------ |
| `under_review`  | Under Review |
| `planned`       | Planned      |
| `in_progress`   | In Progress  |
| `completed`     | Completed    |
| `declined`      | Declined     |

`PATCH /internal/ideas/{idea}/status` (`internal.ideas.status.update`) changes an idea's status. It requires a valid `status` and accepts an optional `message` (max 5000). Behaviour:

- If the new status equals the current one, nothing changes and a "Status was already set to ..." message is returned.
- Otherwise, in a transaction, an `IdeaStatusUpdate` record is written capturing `from_status`, `to_status`, the optional message, and the team member who made the change; the idea's status is then updated.
- Every subscriber **except** the team member who made the change is emailed an `IdeaStatusChanged` notification. See [Subscriptions & email notifications](notifications.md).

Each status change is preserved as history, so the idea detail page can show a full timeline of how an idea has progressed.

## Comments and internal notes

Team members can post to either thread on an idea:

- `POST /internal/ideas/{idea}/comments` (`internal.ideas.comments.store`) posts a **public** comment via the same `PostComment` action used on the public site. Because the author is a team member, this also emails other subscribers.
- `POST /internal/ideas/{idea}/notes` (`internal.ideas.notes.store`) posts an **internal** note (`is_internal = true`). Internal notes are only ever shown inside the internal dashboard and never trigger notifications.
