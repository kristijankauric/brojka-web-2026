# PLAN

Last updated: 2026-03-19 11:45 +01:00
Mode: low-risk recovery audit execution

## Principles

1. Non-destructive first.
2. Git is primary rollback mechanism.
3. No full ZIP snapshots unless explicitly requested.
4. Update docs after each completed block:
   - `CURRENT_STATE.md`
   - `PLAN.md`
   - `CHANGELOG_RECOVERY.md`
5. If risky files are touched, make targeted backup only for those paths.

## Block Sequence

## Block A - Baseline Audit Documentation (current block)
- Produce current-state, smoke, parity, and WPML audit docs from read-only probes.
- Consolidate older documents as Confirmed / Outdated / Open.
- Record evidence and deltas with exact endpoints and timestamps.

Exit criteria:
- Required docs exist and include concrete evidence from `2026-03-19` probes.

## Block B - Authenticated Smoke Expansion (next)
- Verify logged-in admin screens and critical edit flows:
  - `wp-admin` dashboard
  - representative page edit
  - WPML translation UI pages
- Record failures with reproducible steps and log snippets.

Exit criteria:
- Each tested flow has PASS/PARTIAL/FAIL with evidence.

Status update (2026-03-19):
- Do not spend additional time on new scripted login retries.
- Treat Block B as `blocked by scripted auth on LocalWP` until explicitly re-opened.
- Continue with read-only unauthenticated verification and documentation in parallel.

## Block C - Low-Risk Remediation Proposal (after B)
- Based on audit findings only, propose smallest safe changes with easy rollback.
- No broad refactors.
- Prioritize config-level and reversible fixes.

Exit criteria:
- Ranked change list (risk, impact, rollback path) prepared.

## Git/Backup Workflow

- Before a larger change block with meaningful edited set, create a commit (docs/config only when applicable).
- For audit-only blocks, commit documentation artifacts as rollback checkpoints.
- For risky file edits, create targeted backup copy next to file or in `!K/backups-targeted/` with timestamp.

## Success Criteria for this audit cycle

1. `CURRENT_STATE.md`, `PLAN.md`, `CHANGELOG_RECOVERY.md` are up to date.
2. `SMOKE_TEST_RESULTS.md` includes concrete endpoint evidence.
3. `PARITY_AUDIT.md` uses live production comparison.
4. `WPML_AUDIT.md` and `WPML_RECOVERY_PLAN.md` define clear next smallest safe step.
