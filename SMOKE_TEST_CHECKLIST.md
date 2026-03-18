# SMOKE TEST CHECKLIST

## Scope
- Goal: Verify local runtime parity against production behavior after topology/bootstrap restore.
- Environment: `brojka2026.local` (LocalWP), production-like layout (`/app`, `/wp`, vendor above webroot).
- Rule: Identify root cause for any failure before attempting fixes.

## Test Legend
- `PASS`: Works as expected and matches production behavior.
- `PARTIAL`: Works with visible limitations, warnings, or intermittent behavior.
- `FAIL`: Broken, wrong output, or HTTP 5xx/4xx where 2xx/3xx is expected.
- Evidence: Record URL, HTTP code, screenshot/log line, and timestamp.

## 1) Bootstrap and Access
- [ ] Homepage loads (`/`) with 200 and no fatal output.
- [ ] Login page loads (`/wp/wp-login.php`) with 200.
- [ ] Admin entry (`/wp-admin/` -> `/wp/wp-admin/`) redirects/loads correctly.
- [ ] REST root loads (`/wp-json/`) with 200.
- [ ] No new fatals in `logs/php/error.log` and `debug.log` during test window.

## 2) Homepage Parity
- [ ] Hero and primary content sections render.
- [ ] Main navigation renders and links resolve.
- [ ] Theme assets load from `/app/...` (no hard dependency on `/wp-content/...`).
- [ ] Representative JS/CSS files return 200.
- [ ] No obvious visual regressions (layout shift, missing fonts/images, broken blocks).

## 3) Main Pages
- [ ] Key Croatian pages open with 200.
- [ ] Key English pages open with 200.
- [ ] Core service pages (video/animacija/interaktivno) render correctly.
- [ ] No unexpected 404/500 on internal navigation.

## 4) Custom Post Types (CPT)
- [ ] Public CPT archives (if enabled) load.
- [ ] Single CPT items load.
- [ ] REST exposure of expected post types/routes is present.
- [ ] Admin list screens for critical CPTs load without PHP errors.

## 5) Menus and Navigation
- [ ] Header menu items are correct and ordered.
- [ ] Footer menu links work.
- [ ] Language-aware menu switching works (HR/EN).
- [ ] No broken menu targets after topology change.

## 6) Media and Uploads
- [ ] Representative images from `/app/uploads/...` return 200.
- [ ] Featured images appear on homepage and key pages.
- [ ] File permissions allow media read operations.
- [ ] No widespread missing thumbnails/derivatives.

## 7) Forms
- [ ] Contact form pages render correctly.
- [ ] Contact Form 7 endpoints are available.
- [ ] Frontend form submit path returns expected response (test mode/local SMTP rules apply).
- [ ] Validation and anti-spam behavior is not crashing page load.

## 8) Multilingual / WPML
- [ ] HR and EN switching works on frontend.
- [ ] WPML REST namespaces respond.
- [ ] Translation admin screens open without fatal errors.
- [ ] Localized URLs resolve consistently.

## 9) Key Plugins
- [ ] MU framework loader active and stable.
- [ ] Yoast endpoints present and no fatal side effects.
- [ ] WP Rocket/cache layer does not mask dynamic fatals.
- [ ] Any mission-critical custom/plugin integration paths are reachable.

## 10) Logging and Stability Window
- [ ] Repeat access test (5x) for `/`, `/wp/wp-login.php`, `/wp/wp-admin/`, `/wp-json/`.
- [ ] No intermittent 500s across repeated requests.
- [ ] No new fatal stack traces generated during repeats.

## Reporting Template
- Status summary:
  - Works:
  - Partially works:
  - Not working:
- Root causes identified:
- Visual/function differences vs production:
- Next blocker:
- Recommended next action (non-destructive first):
