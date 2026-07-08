# Feedback (ideas)

Feedback items are called **ideas** internally. They are the core content of FeedbackPit: a title, a description, an author, a vote count, a status, and threads of comments and reactions.

## Submitting feedback

Signed-in users create feedback from the `Ideas/Create` page.

- `POST /feedback` (`feedback.store`) validates `title` (required, max 255) and `description` (required, max 5000).
- The idea is created through the author's relationship (`$request->user()->ideas()->create(...)`), so the author is set automatically.
- The user is redirected to the dashboard with "Your feedback has been submitted!"

New ideas start with the default status defined by the database (see [Internal team dashboard](internal-dashboard.md) for the status pipeline).

## Viewing feedback

`GET /feedback/{idea}` (`feedback.show`) renders the `Ideas/Show` page. This route is public — anyone, signed in or not, can view an idea. The page includes:

- The idea itself (title, description, status, vote count, reactions, latest status update).
- Whether the current user has voted, is subscribed, and can edit/delete it.
- All **public** comments (internal comments are excluded), oldest first.

## Editing feedback

`GET /feedback/{idea}/edit` (`feedback.edit`) and `PUT /feedback/{idea}` (`feedback.update`) let the **author** edit their own idea. Authorization is enforced by `IdeaPolicy::update`, which only allows the user who created the idea. Only `title` and `description` can be changed, with the same validation as creation.

On success the user is redirected to the idea page with "Your feedback has been updated!"

## Deleting feedback

`DELETE /feedback/{idea}` (`feedback.destroy`) deletes an idea. Authorization is enforced by `IdeaPolicy::delete` — again, only the author may delete. The user is redirected to the dashboard with "Your feedback has been deleted!"

## What the frontend receives

Ideas are serialized by `IdeaResource`, which exposes: `id`, `title`, `description`, `status`, `votes`, `has_voted`, `reactions` (when loaded), `is_subscribed`, `can.update` / `can.delete` (per-user permissions), the author, comment counts, and status-update history. This resource is reused across the dashboard, the idea page, and the internal dashboard.
