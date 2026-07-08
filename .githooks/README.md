# Git hooks

Shared, version-controlled git hooks for this repo.

## One-time setup (per clone)

```sh
git config core.hooksPath .githooks
```

That's it — git will now run the hooks in this directory instead of `.git/hooks`.

## Hooks

### `pre-commit`

On every commit, runs the **docs-writer** subagent (headless `claude -p`) against
the staged diff and auto-stages any `/docs` pages it updates, so documentation
stays in lockstep with the code in the same commit.

- Best-effort: if the `claude` CLI is missing or the run fails, the commit still
  proceeds — the hook never blocks a commit.
- Skips when nothing is staged, or when the only staged changes are under `docs/`.
- To commit without it once: `git commit --no-verify`.
