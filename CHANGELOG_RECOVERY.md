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

## 2026-03-19 - Read-only authenticated smoke block (attempt)

### What was attempted
- Read-only login to local admin (`/wp/wp-login.php`) using credentials provided in chat.
- Planned follow-up was navigation through core admin + WPML admin screens without save/repair actions.

### Result
- Blocked at authentication step.
- WordPress login error indicated invalid password for username `brojka`.
- No authenticated admin page traversal executed.

### Safety confirmation
- No code changes.
- No WPML repair/sync/tool actions.
- No content save actions.

## 2026-03-19 - Read-only authenticated smoke block (second attempt)

### What was attempted
- Second read-only login attempt to local admin (`/wp/wp-login.php`) using additional credentials provided in chat.

### Result
- Blocked at authentication step.
- WordPress login error indicated unknown username `parcel` (user not registered on this site).
- No authenticated admin page traversal executed.

### Safety confirmation
- No code/runtime changes.
- No WPML repair/sync/tool actions.
- No content save actions.

## 2026-03-19 - Read-only authenticated smoke block (third attempt)

### What was attempted
- Third read-only login attempt with additional credentials provided in chat (`webadmin` + provided password).

### Result
- Authentication not established; flow returned to login URL with `reauth=1`.
- Returned login page did not expose explicit `#login_error` text block and did not show cookie-block warning.
- No authenticated admin/WPML page traversal executed.

### Safety confirmation
- No code/runtime changes.
- No WPML repair/sync/tool actions.
- No content save actions.

## 2026-03-19 - Read-only authenticated smoke block (fourth attempt)

### What was attempted
- Fourth read-only login attempt with two additional credentials from chat (`AI-agent` and `codex`).

### Result
- Both attempts failed to establish authenticated admin session.
- Both returned to login URL with `reauth=1`.
- No authenticated admin/WPML traversal executed.

### Safety confirmation
- No code/runtime changes.
- No WPML repair/sync/tool actions.
- No content save actions.

## 2026-03-19 - Read-only authenticated smoke block (fifth attempt with diagnostics)

### What was attempted
- Additional login attempts with provided credentials (`webadmin`, `AI-agent`, `codex`) using browser-like POST headers/body formatting.
- Read-only inspection of login form structure to detect extra auth requirements.

### Result
- Authentication still not established; all attempts returned to `wp-login.php?...&reauth=1`.
- No explicit login error shown for these attempts.
- Login form appears standard WP login form (no obvious captcha/2FA field in markup).
- Authenticated admin/WPML traversal remains blocked.

### Safety confirmation
- No code/runtime changes.
- No WPML repair/sync/tool actions.
- No content save actions.

## 2026-03-19 - Read-only authenticated smoke block (sixth attempt)

### What was attempted
- Login attempt using explicitly designated WP smoke-test account (`localtest`).

### Result
- Authentication not established; returned to `wp-login.php?...&reauth=1`.
- No authenticated admin/WPML traversal possible.

### Safety confirmation
- No code/runtime changes.
- No WPML repair/sync/tool actions.
- No content save actions.

## 2026-03-19 - Audit direction update (auth boundary + unauth continuation)

### Decision applied
- Stop further scripted login retries.
- Mark authenticated smoke as blocked by scripted auth behavior on LocalWP.
- Continue only with read-only unauthenticated checks.

### Verified in this continuation block
- Public pages: `/`, `/en/`, `/blog/`, `/en/blog/` -> `200`.
- Admin/WPML admin endpoints (unauthenticated): redirect to login with `reauth=1` and load login page (`200`).
- WPML REST and language signals remain available (`/wp-json/wpml/v1`, WPML namespaces, hreflang markers).
- Log sample: no fatal errors in inspected tail window; warnings/deprecated noise remains high.

### Safety confirmation
- No save/sync/repair actions.
- No code/runtime mutation outside documentation updates.
