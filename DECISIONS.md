# Design decisions

The rules every change to this codebase is checked against. They're deliberately
specific: a change either breaks one or it doesn't.

## 1. Controllers don't own workflows

A controller translates the request, calls one action, and returns a response.
Multi-step business workflows live in `app/Actions`.

## 2. One fact, one owner

Never store a second copy of a fact the database already knows — no mirror
flags, no stored totals of things a relationship can already count.

## 3. Writes go through the owning model

Never write to a table with `DB::table()`. Data changes go through the model
that owns the table, so casts, observers, and events run.

## 4. Every catch recovers, retries, or reports

A catch block does one of three things: recover, retry, or report. An empty
catch is never acceptable.

## 5. No abstraction before the second use

No interfaces with a single implementation. No factories for something
constructed once. Add the abstraction when the second case arrives.
