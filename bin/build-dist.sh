#!/usr/bin/env bash
set -e

PLUGIN_DIR="$(cd "$(dirname "$0")/.." && pwd)"
DIST_DIR="$PLUGIN_DIR/dist"

echo "Building assets..."
cd "$PLUGIN_DIR"
npm ci
npm run build

echo "Creating dist directory..."
rm -rf "$DIST_DIR"
mkdir -p "$DIST_DIR"

echo "Copying plugin files..."
rsync -a \
  --exclude-from="$PLUGIN_DIR/.svnignore" \
  --exclude="dist" \
  --exclude=".svnignore" \
  "$PLUGIN_DIR/" "$DIST_DIR/"

echo ""
echo "Done. Distribution build at: $DIST_DIR"
