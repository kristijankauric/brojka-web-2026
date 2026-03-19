# WPML AUDIT

Date: 2026-03-19
Mode: non-destructive, read-only

## WPML runtime signals

### Frontend
- `http://brojka2026.local/en/` returns `200`.
- `http://brojka2026.local/?lang=en` previously verified as `200`.
- Homepage contains:
  - `hreflang="hr"`
  - `hreflang="en"`
  - `hreflang="x-default"`

### REST/API
- `http://brojka2026.local/wp-json/wpml/v1` returns `200`.
- REST root contains WPML namespaces:
  - `wpml/v1`
  - `wpml/st/v1`
  - `wpml/tm/v1`
  - `wpml/ate/v1`

### Plugin set and versions (filesystem/meta)
- Core plugin: `sitepress-multilingual-cms` (release notes mention `4.7.3`).
- String Translation: `wpml-string-translation` (`WPML_ST_VERSION = 3.3.2`).
- WPML SEO: `wp-seo-multilingual` (`WPSEOML_VERSION = 2.1.1`).
- ACFML folder present (`app/public/app/plugins/acfml`).

### Dependency/class presence
- Confirmed present in active WPML core path:
  - `vendor/wpml/wpml/src/UserInterface/Web/Infrastructure/WordPress/CompositionRoot/Config/Event/Translation/Posts/PostInsertedEvent.php`
- This invalidates older “missing class” blocker note from historical docs.

## Log signal relevant to WPML
- No fatal errors found in sampled log tail.
- High deprecated notice volume exists, but sampled lines are mostly non-WPML (`facebook`, `illuminate`, `acf`, custom framework).
- No direct fatal WPML blocker detected in current audit window.

## Risk assessment
- Current risk level for WPML frontend availability: Low.
- Current risk level for WPML admin workflow parity: Medium (not yet smoke-tested while authenticated).
- Current risk level for long-term compatibility/noise: Medium (deprecated warnings).

## Open WPML checks
1. Authenticated `/wp/wp-admin/admin.php?page=sitepress-multilingual-cms/menu/languages.php` load.
2. Translation editor/listing screens smoke.
3. Language switcher behavior on representative inner pages.
4. Verify no intermittent WPML warnings under repeated requests.

## Smallest safe next step
- Execute an authenticated WPML admin smoke mini-pass (read-only navigation) and log outcomes without code changes.

## 2026-03-19 - Authenticated WPML admin check status
- Status: `BLOCKED` (authentication failed before WPML admin navigation).
- Attempt used local credentials provided in chat for user `brojka`.
- Login endpoint returned credential error (invalid password), so WPML admin screens could not be verified in authenticated context.
- No WPML repair/sync/actions were triggered.

## 2026-03-19 - Authenticated WPML admin check status (second attempt)
- Status: `BLOCKED` (authentication failed before WPML admin navigation).
- Attempt used local credentials provided in chat for user `parcel`.
- Login endpoint returned user-not-found error (`Korisničko ime parcel nije registrirano`), so WPML admin screens could not be verified in authenticated context.
- No WPML repair/sync/actions were triggered.

## 2026-03-19 - Authenticated WPML admin check status (third attempt)
- Status: `BLOCKED` (authentication failed before WPML admin navigation).
- Attempt used local credentials provided in chat for user `webadmin`.
- Login flow returned back to `/wp/wp-login.php?...&reauth=1` without authenticated admin session; no explicit `login_error` block was present in returned HTML.
- No WPML repair/sync/actions were triggered.

## 2026-03-19 - Authenticated WPML admin check status (fourth attempt)
- Status: `BLOCKED` (authentication failed before WPML admin navigation).
- Attempts used local credentials provided in chat for users `AI-agent` and `codex`.
- Both login attempts returned to `/wp/wp-login.php?...&reauth=1` without authenticated admin session.
- No WPML repair/sync/actions were triggered.

## 2026-03-19 - Authenticated WPML admin check status (fifth attempt, diagnostics)
- Status: `BLOCKED` (authentication failed before WPML admin navigation).
- Re-tested provided accounts with browser-like login request formatting.
- All attempts still returned to `/wp/wp-login.php?...&reauth=1` without admin session.
- Login form inspection did not reveal extra auth fields (captcha/2FA nonce fields not present in rendered form).
- No WPML repair/sync/actions were triggered.

## 2026-03-19 - Authenticated WPML admin check status (sixth attempt)
- Status: `BLOCKED` (authentication failed before WPML admin navigation).
- Attempt used account explicitly provided for smoke test: `localtest`.
- Login still returned to `/wp/wp-login.php?...&reauth=1` without authenticated admin session.
- No WPML repair/sync/actions were triggered.

## 2026-03-19 - Authentication boundary clarified
- Manual/browser auth: confirmed by user as working.
- Scripted/programmatic auth from this automation context: blocked (reauth loop), independent of username/password correctness.
- Conclusion for audit scope: authenticated WPML admin checks are blocked by LocalWP scripted auth behavior, not by confirmed absence of WP accounts.

## 2026-03-19 - Unauthenticated WPML verification (continued)
- `http://brojka2026.local/wp-json/wpml/v1` -> `200`.
- WPML namespaces in REST root remain present:
  - `wpml/v1`
  - `wpml/st/v1`
  - `wpml/tm/v1`
  - `wpml/ate/v1`
- Frontend language indicators still present:
  - `hreflang="hr"`
  - `hreflang="en"`
  - `hreflang="x-default"`
- Unauthenticated access to WPML admin URL correctly redirects to login with `reauth=1` (expected without session).

### Updated WPML assessment
- Confirmed: WPML frontend/REST layer is operational in unauthenticated scope.
- Blocked: WPML authenticated admin workflow verification due to scripted auth limitation on LocalWP.
- Suspicious but non-fatal: high warning/deprecated noise in debug log tail; no WPML fatal observed in sampled window.
