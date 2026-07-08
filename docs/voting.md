# Voting

Signed-in users can upvote ideas to signal support.

## How it works

`POST /feedback/{idea}/vote` (`feedback.vote`) toggles the current user's vote on an idea:

- If the user **has not** voted, their vote is added, the idea's cached `votes` count is incremented, and they are **automatically subscribed** to the idea (so they receive updates — see [Subscriptions & email notifications](notifications.md)).
- If the user **has** voted, their vote is removed and the `votes` count is decremented. Removing a vote does **not** unsubscribe them.

The whole toggle runs inside a database transaction with a row lock (`lockForUpdate`) so concurrent votes can't corrupt the count. After voting, the user is redirected back to the page they came from.

## Data model

Votes are stored in the `idea_vote` pivot table linking users and ideas (`Idea::voters()` / `User::votedIdeas()`). The `votes` column on the idea is a denormalized counter kept in sync with the pivot.

`IdeaResource` exposes `votes` (the count) and `has_voted` (whether the current user has voted) so the frontend can render vote buttons and totals.
