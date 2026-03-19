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
