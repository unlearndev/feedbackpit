# Module boundaries

Notes on applying modular-monolith ideas (see [Modularizing the monolith](modularizing-the-monolith-a-real-world-experience.md)) to this application.

- Public and internal are real boundaries. Internal functionality already has its own routes, middleware, and controllers, and should stay separated from the public-facing application.
- Account settings is not a meaningful module boundary. It is mostly a couple of controllers grouped under the same URL prefix and does not need its own domain/module.
- Idea is shared across the application. Public features, internal features, comments, feedback, and other parts of the app all depend on it, so it should not belong to a single feature module.
- Shared code should stay shared rather than being duplicated just to make module folders look self-contained.
- Prefer boundaries that reflect how the application actually behaves over forcing every controller or model into a module.
