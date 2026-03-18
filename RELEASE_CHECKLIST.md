# Release Checklist

Complete all items before tagging and deploying a new plugin version.

---

## Version Bump

- [ ] **`add-whatsapp-button.php`** — Update the `Version:` line in the file docblock
  ```
  Version: X.X.X
  ```
- [ ] **`readme.txt`** — Update `Stable tag:` in the header
  ```
  Stable tag: X.X.X
  ```
- [ ] **`package.json`** — Update the `"version"` field
  ```json
  "version": "X.X.X"
  ```

> All three version values must match.

---

## readme.txt Updates

- [ ] Update `Tested up to:` to the latest WordPress version you have tested against
- [ ] Add a new entry to the `== Changelog ==` section:
  ```
  = X.X.X =
  * Description of changes
  ```
- [ ] Review the `== Description ==` section — update if features have changed
- [ ] Review `== Frequently Asked Questions ==` — add/update entries if needed
- [ ] Review `== Screenshots ==` — update if the UI has changed

---

## Code

- [ ] All new code is tested locally in the LocalWP environment
- [ ] No debug output (`console.log`, `error_log`, `var_dump`) left in production code
- [ ] Run the JS build: `npm run build`
- [ ] Confirm `js/admin.js` was updated by the build
- [ ] Check for PHP errors or warnings in the WordPress admin and on the frontend
- [ ] Test on a clean installation (no pre-existing settings) if the release changes stored data

---

## Compatibility

- [ ] Tested against the latest stable WordPress release
- [ ] Tested against the minimum supported WordPress version (`Requires at least:` in readme.txt)
- [ ] Tested with PHP 7.4+ and PHP 8.x

---

## Git

- [ ] All changes committed and pushed to `master`
- [ ] No uncommitted changes (`git status` is clean)

---

## Deploy

- [ ] Push a version tag to trigger the GitHub Actions deploy:
  ```bash
  git tag v<version>
  git push origin v<version>
  ```
- [ ] Monitor the Actions tab on GitHub for deploy status
- [ ] Verify the new version appears on the WordPress.org plugin page
- [ ] Install the update on a test site and confirm it works
