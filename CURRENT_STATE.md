# CURRENT STATE

Last updated: 2026-03-19 11:45 +01:00
Audit mode: non-destructive, documentation-first

## 1) Verified Runtime State

### Core local endpoints (brojka2026.local)
| Endpoint | HTTP | Notes |
|---|---:|---|
| `http://brojka2026.local/` | 200 | Front page renders (`brojka` theme visible) |
| `http://brojka2026.local/en/` | 200 | EN page renders |
| `http://brojka2026.local/wp/wp-login.php` | 200 | Login page loads |
| `http://brojka2026.local/wp/wp-admin/` | 200 | Redirects to login when unauthenticated |
| `http://brojka2026.local/wp-json/` | 200 | REST root available |
| `http://brojka2026.local/wp-json/wpml/v1` | 200 | WPML REST namespace available |
| `http://brojka2026.local/sitemap_index.xml` | 200 | Sitemap available |

### Live parity probe (production `https://brojka.hr`)
| Endpoint | Local HTTP / bytes | Prod HTTP / bytes | Delta |
|---|---:|---:|---|
| `/` | 200 / 77794 | 200 / 84404 | Size differs (expected minor content/config drift) |
| `/en/` | 200 / 78551 | 200 / 85084 | Size differs (expected minor content/config drift) |
| `/wp-json/` | 200 / 334082 | 200 / 326994 | Local has slightly more namespaces/routes |
| `/sitemap_index.xml` | 200 / 1420 | 200 / 1359 | Minor size drift |

### Asset/path parity spot-check
| Asset | Local | Production | Result |
|---|---:|---:|---|
| `/app/themes/brojka/assets/cache/all.css?v1_0_56` | 200 / 209564 | 200 / 209564 | Match |
| `/app/themes/brojka/assets/cache/all.js?v=1.0.56` | 200 / 1087342 | 200 / 1087342 | Match |
| `/app/uploads/2021/07/cropped-Brojka-logo-solo-zupcanik.png` | 200 / 9092 | 200 / 9092 | Match |

## 2) Confirmed Topology

- Core: `app/public/wp` (confirmed by `app/public/index.php` shim to `/wp/wp-blog-header.php` and `app/public/wp/wp-load.php`).
- Content: `app/public/app` (`themes`, `plugins`, `mu-plugins`, `uploads`, ...).
- Vendor/autoload: `app/vendor/autoload.php`.
- Theme: `app/public/app/themes/brojka` present and rendering.
- MU framework: `app/public/app/mu-plugins/sd-wordpress-framework` present.

## 3) WPML Status (read-only)

- Frontend language switch signals:
  - `hreflang="hr"` present
  - `hreflang="en"` present
  - `hreflang="x-default"` present
- REST namespaces present: `wpml/v1`, `wpml/st/v1`, `wpml/tm/v1`, `wpml/ate/v1`.
- Plugin/version signals found in code/meta:
  - WPML core: `4.7.3`
  - WPML String Translation: `3.3.2`
  - WPML SEO: `2.1.1`
- Previously missing class claim is outdated:
  - `.../PostInsertedEvent.php` now exists in active `sitepress-multilingual-cms`.

## 4) Log Summary

Source: `app/public/app/debug.log` tail inspection.

- Fatal errors detected in inspected tail window: `0`
- Deprecated notices (tail sample): high volume (legacy PHP 8.2 compatibility noise)
  - `official-facebook-pixel`
  - `illuminate/*`
  - `sd-wordpress-framework`
  - `sd-acf-pro`

Interpretation:
- Runtime is operational, but noise level in debug log is high.
- This should be treated as a compatibility/cleanup track, not an immediate blocker for current recovery audit.

## 5) Existing Docs Consolidation (Confirmed / Outdated / Open)

| Document | Status | Notes |
|---|---|---|
| `PROJECT_CONTEXT.md` | Confirmed | High-level intent remains valid. |
| `PRODUCTION_PARITY_RESTORE_PLAN.md` | Partially confirmed | Main topology target is valid; some steps already completed. |
| `SMOKE_TEST_CHECKLIST.md` | Needs refresh | Scope valid, needs alignment with current confirmed topology/results. |
| `VENDOR_PATH_DECISION.md` | Confirmed | Vendor above webroot model matches current runtime (`app/vendor`). |
| `WP_CORE_TOPOLOGY_PLAN.md` | Outdated (partially) | Claims about missing `/wp` core are no longer true. |
| `MISSING_DEPENDENCIES_AUDIT.md` | Outdated (partially) | WPML missing class claim no longer true; old `wp-content` assumptions stale. |
| `RESTORE_GAP_CHECKLIST.md` | Outdated (partially) | Safe-mode/missing-state assumptions mostly historical. |
| `MIGRATION_NOTES.md` | Historical | Useful provenance, not current operational truth. |
| `AUTOLOAD_BLOCKER_PLAN.md` | Historical/partly resolved | Main autoload blocker already resolved for current runtime. |

## 6) Open Items

1. Controlled functional smoke across representative content templates (HR + EN + CPT + forms).
2. Deeper parity deltas beyond HTTP/asset parity (menus/content details, admin screens).
3. WPML admin workflow verification (translation screens and edit flows while authenticated).
4. Decide whether and when to reduce deprecated log noise (separate low-risk backlog).

## 7) Smallest Safe Next Step

- Execute authenticated smoke subset (frontend + wp-admin + WPML admin pages) read-only where possible, and append precise evidence to `SMOKE_TEST_RESULTS.md` and `WPML_AUDIT.md` before any code changes.
