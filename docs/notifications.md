# Subscriptions & email notifications

Users can follow ("subscribe to") ideas to receive email updates. Subscriptions drive who gets notified when an idea's status changes or a team member comments.

## How you become subscribed

You are subscribed to an idea when you:

- **Vote** on it (see [Voting](voting.md)).
- **Comment** on it (see [Comments](comments.md)).
- **Explicitly subscribe** from the notification-preferences page.

Subscriptions are stored in the `idea_subscribers` pivot with timestamps (`Idea::subscribers()` / `User::subscribedIdeas()`).

## Managing preferences

The `Account/Notifications` page (`account.notifications.edit`) lists the ideas the current user follows, most recently subscribed first, along with each idea's latest status update.

- `POST /account/notifications/{idea}` (`account.notifications.store`) subscribes the user, with the flash message `Subscribed to "..."`.
- `DELETE /account/notifications/{idea}` (`account.notifications.destroy`) unsubscribes the user, with `Unsubscribed from "..."`.

Subscribed ideas are serialized by `SubscribedIdeaResource` (`id`, `title`, `status`, `latest_status_update`).

## Emails

Two queued email notifications are sent (both use Markdown mail templates under `resources/views/mail/ideas/`):

- **`IdeaStatusChanged`** — sent when a team member changes an idea's status. Delivered to every subscriber **except** the team member who made the change. Subject: `Status update on "<idea title>"`.
- **`IdeaCommentPosted`** — sent when a **team member** posts a public comment. Delivered to every other subscriber. Subject: `New comment on "<idea title>"`.

Both emails include a link to the idea and a **signed, one-click unsubscribe link**.

## One-click unsubscribe

`GET /feedback/{idea}/unsubscribe/{user}` (`feedback.unsubscribe`) is protected by Laravel's `signed` middleware, so it can only be reached through the signed URL embedded in a notification email. Visiting it removes that user's subscription to the idea and shows the `Ideas/Unsubscribed` confirmation page. No login is required.
