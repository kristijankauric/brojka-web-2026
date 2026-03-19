# CHANGELOG RECOVERY

## 2026-03-19 - Audit Block: Recovery Audit Plan v2 implementation (docs-only)

### Context
- User requested continuation in audit/documentation mode with minimal risk.
- Backup policy was updated: no more full-project ZIP snapshots.
- Git is now primary rollback mechanism.

### Added
- `CURRENT_STATE.md`
- `PLAN.md`
- `SMOKE_TEST_RESULTS.md`
- `PARITY_AUDIT.md`
- `WPML_AUDIT.md`
- `WPML_RECOVERY_PLAN.md`
- `!K/snapshots/manifest-<timestamp>.md` (small manifest snapshot, no ZIP)

### Updated
- `SMOKE_TEST_CHECKLIST.md` (aligned to confirmed topology and current evidence)

### Verified (read-only)
- Local endpoints returning 200: `/`, `/en/`, `/wp/wp-login.php`, `/wp/wp-admin/` (login redirect), `/wp-json/`, `/wp-json/wpml/v1`, `/sitemap_index.xml`.
- Production parity probes returning 200: `/`, `/en/`, `/wp-json/`, `/sitemap_index.xml`.
- Asset parity checks for key theme/media files (`/app/themes/...`, `/app/uploads/...`) matched in status and byte size for sampled files.
- WPML namespaces detected in local and production REST roots.
- WPML missing-class historical claim invalidated (`PostInsertedEvent.php` exists in active plugin).

### Notes
- Previous full ZIP attempt artifacts in `!K/snapshots/` are incomplete/aborted and not treated as valid rollback backups.
- Current block intentionally makes no runtime code changes.
- Backup policy switched to git-first + manifest snapshots by user request.

### Open
1. Authenticated admin smoke (including WPML screens).
2. Visual parity review for representative HR/EN inner pages.
3. Optional deprecated warning cleanup track (separate low-risk backlog).
