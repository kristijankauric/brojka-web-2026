# SMOKE TEST RESULTS

Date: 2026-03-19
Method: read-only HTTP probes + file presence checks + debug log tail

## Summary
- PASS: core public/runtime endpoints and critical assets/media
- PARTIAL: admin flow (reachable but unauthenticated only), log cleanliness (deprecated noise)
- FAIL: none in this block

## Endpoint results
| URL | Status | HTTP | Evidence |
|---|---|---:|---|
| `http://brojka2026.local/` | PASS | 200 | Frontpage rendered |
| `http://brojka2026.local/en/` | PASS | 200 | EN page rendered |
| `http://brojka2026.local/wp/wp-login.php` | PASS | 200 | Login page available |
| `http://brojka2026.local/wp/wp-admin/` | PARTIAL | 200 | Redirected to login when unauthenticated |
| `http://brojka2026.local/wp-json/` | PASS | 200 | REST root available |
| `http://brojka2026.local/wp-json/wpml/v1` | PASS | 200 | WPML REST available |
| `http://brojka2026.local/sitemap_index.xml` | PASS | 200 | Sitemap available |

## Asset/media checks
| URL | Status | HTTP | Bytes |
|---|---|---:|---:|
| `/app/themes/brojka/assets/cache/all.css?v1_0_56` | PASS | 200 | 209564 |
| `/app/themes/brojka/assets/cache/all.js?v=1.0.56` | PASS | 200 | 1087342 |
| `/app/uploads/2021/07/cropped-Brojka-logo-solo-zupcanik.png` | PASS | 200 | 9092 |

## Topology/file checks
| Check | Result |
|---|---|
| `app/public/wp/wp-load.php` exists | PASS |
| `app/public/app/themes/brojka` exists | PASS |
| `app/public/app/mu-plugins/sd-wordpress-framework` exists | PASS |
| `app/vendor/autoload.php` exists | PASS |
| WPML `PostInsertedEvent.php` exists in active plugin | PASS |

## Log checks (sample)
- Source: `app/public/app/debug.log` (tail sample)
- Fatal count in sample: `0`
- Deprecated count in sample window: high (`196` in inspected tail window)
- Interpretation: runtime operational; compatibility cleanup backlog remains.

## Open smoke tests
1. Authenticated admin/WPML screens.
2. Visual parity side-by-side capture.
3. Contact form submit path.

## Smallest safe next step
- Run authenticated smoke subset and append results to this file (no code changes).

## 2026-03-19 - Authenticated smoke attempt (blocked)
- Attempted credentials: username `brojka`, password value provided in chat.
- Result: login failed on `http://brojka2026.local/wp/wp-login.php`.
- WordPress error (from `#login_error`): `Lozinka koju ste unijeli za korisničko ime brojka je neispravna.`
- No authenticated admin/WPML screen checks could be executed in this run.

## 2026-03-19 - Authenticated smoke attempt #2 (blocked)
- Attempted credentials: username `parcel`, password value provided in chat.
- Result: login failed on `http://brojka2026.local/wp/wp-login.php`.
- WordPress error (from `#login_error`): `Korisničko ime parcel nije registrirano na ovoj web-stranici.`
- No authenticated admin/WPML screen checks could be executed in this run.

## 2026-03-19 - Authenticated smoke attempt #3 (blocked)
- Attempted credentials: username `webadmin`, password value provided in chat.
- Result: request returned to login form (`/wp/wp-login.php?redirect_to=...&reauth=1`) without authenticated session.
- Observed login page state:
  - no explicit `#login_error` block detected in returned HTML,
  - no cookie-block warning detected,
  - login not established (no admin bar/admin UI markers).
- No authenticated admin/WPML screen checks could be executed in this run.

## 2026-03-19 - Authenticated smoke attempt #4 (blocked)
- Attempted credentials: `AI-agent` and `codex` with passwords provided in chat.
- Result for both attempts: returned to `wp-login.php?...&reauth=1` without authenticated session.
- Observed login page state for both:
  - no explicit `#login_error` block detected in returned HTML,
  - no cookie warning detected,
  - login not established.
- No authenticated admin/WPML screen checks could be executed in this run.

## 2026-03-19 - Authenticated smoke attempt #5 (blocked, extended diagnostics)
- Re-tested credentials with browser-like POST headers and URL-encoded form body.
- Tested pairs:
  - `webadmin` + provided password
  - `AI-agent` + provided password
  - `codex` + provided password
- Result: all attempts returned to `wp-login.php?...&reauth=1` without authenticated session.
- Diagnostics:
  - login form has standard WP fields only (`log`, `pwd`, `rememberme`, `wp-submit`, `redirect_to`, `testcookie`),
  - no captcha/2FA field detected in login form markup,
  - no cookie-block warning displayed,
  - no explicit `#login_error` displayed for these attempts.
- No authenticated admin/WPML screen checks could be executed in this run.

## 2026-03-19 - Authenticated smoke attempt #6 (blocked)
- Attempted credentials: `localtest / LocalTest2026!` (explicitly designated as WP account for smoke test).
- Result: returned to `wp-login.php?...&reauth=1` without authenticated session.
- `login_error` block was not present in returned HTML body for this attempt.
- No authenticated admin/WPML screen checks could be executed in this run.

## 2026-03-19 - Read-only unauthenticated smoke continuation
- Decision applied: stop further scripted login attempts.
- Auth separation:
  - `Manual login`: confirmed by user as working in browser on `http://brojka2026.local/wp/wp-login.php`.
  - `Scripted/programmatic login`: blocked in this LocalWP setup (reauth loop / no active admin session).

### Unauthenticated checks executed
| URL | Status | HTTP | Final URL / note |
|---|---|---:|---|
| `/` | PASS | 200 | Front loads |
| `/en/` | PASS | 200 | EN front loads |
| `/blog/` | PASS | 200 | HR blog loads |
| `/en/blog/` | PASS | 200 | EN blog loads |
| `/wp/wp-login.php` | PASS | 200 | Login form loads |
| `/wp/wp-admin/` | PASS | 200 | Redirects to login with `reauth=1` |
| `/wp/wp-admin/edit.php?post_type=page` | PASS | 200 | Redirects to login with `reauth=1` |
| `/wp/wp-admin/admin.php?page=sitepress-multilingual-cms/menu/languages.php` | PASS | 200 | Redirects to login with `reauth=1` |
| `/wp-json/` | PASS | 200 | REST root available |
| `/wp-json/wpml/v1` | PASS | 200 | WPML REST namespace available |
| `/wp-json/wp/v2/pages?per_page=5` | PASS | 200 | Pages endpoint works |
| `/wp-json/wp/v2/pages?per_page=5&lang=en` | PASS | 200 | EN-filtered pages endpoint works |
| `/sitemap_index.xml` | PASS | 200 | Sitemap available |

### Additional signals
- `hreflang` on homepage: `hr`, `en`, `x-default` all present.
- WPML REST namespaces present: `wpml/v1`, `wpml/st/v1`, `wpml/tm/v1`, `wpml/ate/v1`.
- Log tail (`debug.log`, 300 lines): fatal count `0`; warnings/notices/deprecated present in high volume.

### Status after this block
- Authenticated smoke remains blocked by scripted auth behavior on LocalWP.
- Unauthenticated runtime/WPML surface remains operational.
