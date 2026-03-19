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
