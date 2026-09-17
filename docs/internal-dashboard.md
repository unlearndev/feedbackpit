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

Each status change is preserved as history, so the idea detail page can show a timeline of how an idea has progressed.

The `idea_status_updates` table carries a unique index, `idea_status_transition_unique`, across `idea_id`, `user_id`, `from_status`, and `to_status`. A single team member can therefore only ever record a given transition on a given idea once. This matters when an idea revisits an earlier status: if the same team member moves an idea from Planned to In Progress, it later goes back to Planned, and they move it to In Progress again, the second record duplicates all four columns and the database rejects it. The controller does not catch the violation, so it surfaces as a database error (reported to Sentry — see [Error monitoring](error-monitoring.md)) rather than as an inline validation message.

The same transition made by a **different** team member is unaffected, as is the same team member making any other transition on that idea.

## Merging duplicate ideas

When the same suggestion has been submitted more than once, a team member can merge the duplicate into the idea they want to keep. The merge form sits on the idea detail page, below the status controls: a dropdown listing every **other** idea (passed to the page as `mergeTargets` — id and title only, ordered by title) and a **Merge** button.

`POST /internal/ideas/{idea}/merge` (`internal.ideas.merge.store`) takes `target_id`, the idea being kept. The idea in the URL is the duplicate being merged away, and for it the controller:

- Reassigns **all** of its comments to the target, internal notes included.
- Reassigns its reactions to the target.
- Attaches each of its voters to the target.
- Stores the target in `merged_into_id` (exposed on the model as the `mergedInto` relationship).
- Sets its status to **Declined**.

The team member is redirected to the target idea with "Idea merged into ...".

### Things to know

- The status change is written straight to the idea. Unlike a status change made through the status pipeline, no `IdeaStatusUpdate` record is created and **no subscribers are emailed**, so the merge leaves no trace in the idea's history and people following the duplicate are not told about it.
- Votes and reactions are moved without checking for overlap. `idea_vote` is unique across `idea_id` and `user_id`, and `reactions` is unique across `idea_id`, `user_id`, and `emoji`. If the same person voted on both ideas, or left the same emoji on both, the merge fails with a database error (reported to Sentry — see [Error monitoring](error-monitoring.md)) rather than an inline message.
- The merge is not wrapped in a transaction, so a failure part-way through leaves the earlier steps applied — comments and reactions may already have moved to the target while the votes did not.
- `target_id` is not validated. The dropdown's placeholder option submits an empty value, and an empty or unknown id fails with an error rather than a validation message. Nothing stops an idea being merged into itself or into an idea that has already been merged away.
- Merging does not hide or redirect the duplicate. It still appears (as Declined) on the public dashboard, in the internal idea list, and in the merge dropdown of other ideas — but its comments, reactions, and votes now live on the target. `merged_into_id` is not exposed by `IdeaResource`, so no page links a merged idea to the idea it was merged into.

## Comments and internal notes

Team members can post to either thread on an idea:

- `POST /internal/ideas/{idea}/comments` (`internal.ideas.comments.store`) posts a **public** comment via the same `PostComment` action used on the public site. Because the author is a team member, this also emails other subscribers.
- `POST /internal/ideas/{idea}/notes` (`internal.ideas.notes.store`) posts an **internal** note (`is_internal = true`). Internal notes are only ever shown inside the internal dashboard and never trigger notifications.
