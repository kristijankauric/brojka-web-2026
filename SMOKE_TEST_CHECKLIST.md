# SMOKE TEST CHECKLIST

Last updated: 2026-03-19 11:45 +01:00

## Scope
- Goal: validate runtime stability and critical user/admin access after topology recovery.
- Environment: `http://brojka2026.local` (LocalWP), production-like layout (`/wp` core, `/app` content).
- Method: read-only checks first, then authenticated checks in separate block.

## Evidence format
- `Status`: PASS / PARTIAL / FAIL
- `Proof`: URL + HTTP code + timestamp (+ note)

## A) Access & bootstrap
- [x] `/` returns 200
- [x] `/en/` returns 200
- [x] `/wp/wp-login.php` returns 200
- [x] `/wp/wp-admin/` reachable (redirect to login when logged out)
- [x] `/wp-json/` returns 200
- [x] `/wp-json/wpml/v1` returns 200
- [x] `/sitemap_index.xml` returns 200

## B) Theme/assets/media
- [x] Theme CSS from `/app/themes/brojka/assets/cache/all.css` returns 200
- [x] Theme JS from `/app/themes/brojka/assets/cache/all.js` returns 200
- [x] Representative upload from `/app/uploads/...` returns 200
- [ ] Visual regression pass (manual screenshot comparison HR/EN)

## C) Multilingual
- [x] HR homepage has `hreflang=hr`
- [x] HR homepage has `hreflang=en`
- [x] HR homepage has `hreflang=x-default`
- [ ] Language switch interaction test (menu/UI) in browser session
- [ ] WPML admin screens smoke while logged in

## D) Admin/CPT/forms (pending authenticated block)
- [ ] Dashboard load without fatal
- [ ] Representative page edit load
- [ ] CPT list screens load
- [ ] Contact form page render and endpoint sanity

## E) Stability/logs
- [x] No fatal errors detected in latest debug tail sample
- [x] Deprecated notice volume noted as non-blocking signal
- [ ] Repeated-request stability window (5x loop with timestamps)

## Open smoke gaps
1. Authenticated admin smoke not yet executed in this block.
2. Visual parity still needs side-by-side capture.
3. Form submit behavior not yet tested.
