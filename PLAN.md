# WordPress SVN Integration & GitHub Actions Deployment Plan

## Overview

Connect the GitHub repository to the WordPress Plugin Directory SVN and automate deployment via GitHub Actions.

---

## Phase 1: SVN Configuration

### 1.1 Add `.svnignore` file

WordPress Plugin Directory SVN should not include development files. Create a `.svnignore` (used by the deploy action) to exclude:

```
.git
.gitignore
.github
node_modules
src
webpack.config.js
package.json
package-lock.json
PLAN.md
RELEASE_CHECKLIST.md
README.md
```

The deploy action will use this to build a clean SVN commit from only the distributable files.

### 1.2 Understand SVN structure

The WordPress SVN repo for this plugin lives at:
`https://plugins.svn.wordpress.org/add-whatsapp-button/`

It has three directories:
- `trunk/` — the latest version (auto-synced from the GitHub `master` branch on deploy)
- `tags/` — one subfolder per release (e.g. `tags/2.1.8/`), which is what WordPress serves to users
- `assets/` — plugin page assets (banner, icon, screenshots) — **not** included in the plugin zip

### 1.3 SVN credentials as GitHub Secrets

In the GitHub repository settings, add two repository secrets:
- `SVN_USERNAME` — your WordPress.org username
- `SVN_PASSWORD` — your WordPress.org password (or application password)

---

## Phase 2: GitHub Actions Workflow

### 2.1 Create `.github/workflows/deploy.yml`

Use the [`10up/action-wordpress-plugin-deploy`](https://github.com/10up/action-wordpress-plugin-deploy) action — the de facto standard for this workflow.

The workflow should:
- Trigger on a push to `master` **only when a version tag is pushed** (e.g., `v2.1.8`)
- Run `npm install && npm run build` to compile JS assets before deploying
- Deploy the compiled plugin to WordPress SVN (`trunk/` and a new `tags/<version>/`)

The version number is read automatically from the `Version:` header in `add-whatsapp-button.php`.

### 2.2 Workflow file location

`.github/workflows/deploy.yml`

---

## Phase 3: Files to Create

| File | Purpose |
|---|---|
| `.svnignore` | Tells deploy action which files to exclude from SVN |
| `.github/workflows/deploy.yml` | GitHub Actions deploy workflow |
| `RELEASE_CHECKLIST.md` | Pre-release checklist (already created) |

---

## Phase 4: One-Time Setup Steps

1. Confirm your WordPress.org account has commit access to `add-whatsapp-button` in the plugin directory.
2. Add `SVN_USERNAME` and `SVN_PASSWORD` secrets in GitHub → Settings → Secrets and variables → Actions.
3. Verify the plugin slug in `deploy.yml` matches the directory name on WordPress SVN (`add-whatsapp-button`).
4. Test by pushing a version tag (e.g., `git tag v2.1.8 && git push origin v2.1.8`).

---

## Phase 5: Release Flow (Ongoing)

1. Complete all items in `RELEASE_CHECKLIST.md`.
2. Commit and push changes to `master`.
3. Push a version tag: `git tag v<version> && git push origin v<version>`.
4. GitHub Actions builds assets and deploys to WordPress SVN automatically.
5. Check the Actions tab on GitHub for deploy status.
6. Verify the new version appears on `https://wordpress.org/plugins/add-whatsapp-button/`.

---

## Notes

- The `readme.txt` and `add-whatsapp-button.php` `Version:` header must match — the deploy action reads the version from the PHP file and creates the SVN tag accordingly.
- The `js/` folder is in `.gitignore` (compiled output). The deploy action runs the build step so compiled assets are included in SVN even though they are not committed to Git. Confirm this is handled in the workflow's build step.
- `assets/` on SVN (banners, icons, screenshots) is managed separately and is **not** overwritten by the deploy action unless you configure it to do so.
