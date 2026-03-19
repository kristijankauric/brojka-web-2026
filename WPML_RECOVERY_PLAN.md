# WPML RECOVERY PLAN

Date: 2026-03-19
Strategy: minimal-risk, reversible, evidence-driven

## Objective
Keep WPML fully operational in local recovery environment while avoiding aggressive plugin/core changes.

## Phase 1 - Confirm admin workflow parity (no code changes)
1. Login and open key WPML admin screens.
2. Check translation listing/edit entry points.
3. Record PASS/PARTIAL/FAIL with URL + timestamp + log snippets.

Rollback: none needed (read-only navigation).

## Phase 2 - Stabilize runtime noise (only if needed)
1. Classify deprecated warnings by source package.
2. Decide whether to suppress non-critical deprecated output in local env only (no production behavior change).
3. Keep WPML-related warnings separate from non-WPML warnings.

Rollback: config-only revert via git commit.

## Phase 3 - Targeted low-risk fixes (if blockers appear)
1. Apply smallest isolated fix for the confirmed blocker only.
2. Backup touched risky files to `!K/backups-targeted/<timestamp>/` before edit.
3. Re-test only affected WPML flow + core smoke endpoints.

Rollback: git revert or restore targeted backup.

## Guardrails
- No plugin bulk updates.
- No schema/data migrations without explicit need.
- No disabling WPML components unless a fatal blocker is proven and documented.
- Every actual change must be recorded in `CHANGELOG_RECOVERY.md`.

## Exit criteria
- WPML frontend switch remains stable (HR/EN endpoints 200).
- WPML REST namespaces stay available.
- Key WPML admin pages load without fatal.
- Any change is documented with rollback path.

## Smallest safe next step
- Perform Phase 1 authenticated WPML admin smoke and append evidence to `WPML_AUDIT.md`.
