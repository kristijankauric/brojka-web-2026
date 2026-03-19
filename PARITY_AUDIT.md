# PARITY AUDIT

Date: 2026-03-19
Source of truth for comparison: live production (`https://brojka.hr`)
Method: read-only HTTP and REST probes

## High-level status
- Critical parity paths are operational locally.
- Core URLs, WPML REST namespaces, and key theme/media assets match expected production path model (`/wp` + `/app`).
- Remaining differences are currently non-critical and mostly content/route-count drift.

## Endpoint comparison
| Area | Local | Production | Severity | Note |
|---|---|---|---|---|
| Homepage `/` | 200, 77794 bytes | 200, 84404 bytes | Cosmetic | Size drift, both render |
| English `/en/` | 200, 78551 bytes | 200, 85084 bytes | Cosmetic | Size drift, both render |
| REST `/wp-json/` | 200, 334082 bytes | 200, 326994 bytes | Medium | Local routes/namespaces count slightly higher |
| Sitemap | 200, 1420 bytes | 200, 1359 bytes | Cosmetic | Minor XML size drift |

## REST parity details
| Metric | Local | Production | Severity |
|---|---:|---:|---|
| Namespace count | 13 | 12 | Medium |
| Route count | 309 | 303 | Medium |
| WPML namespaces (`wpml/v1`, `wpml/st/v1`, `wpml/tm/v1`, `wpml/ate/v1`) | Present | Present | None |
| `url` in REST root | `http://brojka2026.local/wp` | `https://brojka.hr/wp` | None |
| `home` in REST root | `http://brojka2026.local` | `https://brojka.hr` | None |

## Asset path parity
| Asset | Local | Production | Severity |
|---|---|---|---|
| `/app/themes/brojka/assets/cache/all.css?v1_0_56` | 200, 209564 | 200, 209564 | None |
| `/app/themes/brojka/assets/cache/all.js?v=1.0.56` | 200, 1087342 | 200, 1087342 | None |
| `/app/uploads/.../cropped-Brojka-logo-solo-zupcanik.png` | 200, 9092 | 200, 9092 | None |

## Hreflang parity signal
- Local homepage includes `hreflang="hr"`, `hreflang="en"`, `hreflang="x-default"`.
- Production also provides multilingual SEO signal (implicit from EN path and WPML stack).
- Severity: None.

## Parity gaps still open
1. Authenticated admin/WPML parity (menu/screens/workflows) not yet verified.
2. Visual content parity across representative inner pages still pending.
3. Route-count drift source analysis (which extra local namespaces/routes) still pending.

## Smallest safe next step
- Run a narrow authenticated parity pass for 3 admin pages + 3 representative content pages and append evidence only.
