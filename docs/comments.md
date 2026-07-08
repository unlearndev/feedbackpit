# Comments

Ideas have a public comment thread where signed-in users can discuss them. Team members also have a separate internal comment thread (see [Internal team dashboard](internal-dashboard.md)).

## Posting a public comment

`POST /feedback/{idea}/comments` (`feedback.comments.store`) posts a comment. The body is required and limited to 5000 characters (`StoreCommentRequest`).

Comment creation is handled by the `PostComment` action, which, in a single transaction:

1. Creates the comment (with `is_internal = false`) associated with the author and idea.
2. **Subscribes the author to the idea** so they are notified of future activity.
3. If the author is a **team member**, sends an `IdeaCommentPosted` email notification to every other subscriber of the idea.

Note that email notifications for new comments are only sent when the commenter is a team member — ordinary member comments do not trigger emails. After posting, the user is redirected back with "Comment posted!"

## Viewing comments

The public idea page (`Ideas/Show`) loads all comments where `is_internal` is `false`, oldest first, each with its author. Comments are serialized by `CommentResource` (`id`, `body`, `user`, `created_at`).

## Data model

Comments belong to a `User` and an `Idea` (`Comment` model). The `is_internal` boolean flag separates public comments from team-only internal notes; the two share the same table and are filtered by this flag everywhere they are displayed.
