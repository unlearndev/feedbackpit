# Changelog & release notes

FeedbackPit generates both its `CHANGELOG.md` and its GitHub release notes automatically when a release is published, driven by the `.github/workflows/changelog.yml` workflow.

## Trigger

The workflow runs on published GitHub releases. Because the Claude Code action does not support the `release` event directly, a published release simply **re-dispatches** the workflow as a `workflow_dispatch` run, passing the release tag. It can also be run manually via `workflow_dispatch` with a `tag` input.

## Collecting the changes

The workflow diffs the new tag against the previous tag (or, for the first release, against the empty tree so every file counts as added). It gathers three things for that range:

- The commit subjects (a rough hint only).
- A diff stat of files changed.
- The full code diff, capped at ~90 KB.

Generated and vendored files are excluded from the diff so it reflects real source changes: `CHANGELOG.md`, `*.lock`, `package-lock.json`, `composer.lock`, and the generated `resources/js/routes/**` and `resources/js/actions/**` output.

## Two generated outputs

The code diff — not the commit messages — is treated as the source of truth for both outputs.

1. **`CHANGELOG.md`** — a technical changelog. Claude groups entries under `### Features`, `### Fixes`, and `### Chores`, written as plain past-tense sentences. A new dated section (`## <tag> - <date>`) is prepended to the file, and the update is committed to `main` by `github-actions[bot]`. If a section for the tag already exists, the step is skipped.

2. **GitHub release notes** — user-facing notes written for the people who use the app, in a fun and playful tone, covering only user-visible changes. These are written back to the release description via `gh release edit`.

Both steps enforce that Claude may only describe capabilities the diff actually shows: removals are never described as additions, and nothing is invented.

The current changelog lives in [`CHANGELOG.md`](../CHANGELOG.md) at the project root.
