# Reactions

Signed-in users can add emoji reactions to an idea, in addition to voting.

## Available emoji

Reactions are limited to a fixed set defined on the `Reaction` model:

```
👍  ❤️  🎉  🚀  👀
```

## How it works

`POST /feedback/{idea}/reactions` (`feedback.react`) toggles a single emoji reaction for the current user:

- The submitted `emoji` is validated to be one of the allowed set (`StoreReactionRequest`).
- If the user has already reacted with that emoji, the reaction is removed.
- Otherwise a new reaction is created and associated with the user and idea.

Each user can react once per emoji, but can use several different emoji on the same idea. After reacting, the user is redirected back.

## What the frontend receives

When the idea's `reactions` relation is loaded, `IdeaResource` returns one entry per allowed emoji with:

- `emoji` — the emoji character.
- `count` — how many users have used it.
- `reacted` — whether the current user has used it.

This lets the idea page render every available reaction with its running total and highlight the ones the current user has chosen.
