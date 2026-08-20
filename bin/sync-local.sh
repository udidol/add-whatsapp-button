#!/usr/bin/env bash
set -e

PLUGIN_DIR="$(cd "$(dirname "$0")/.." && pwd)"

# AWB_LOCAL_PLUGIN_DIR points at the plugin folder inside the local WordPress install.
if [ -f "$PLUGIN_DIR/.env" ]; then
  set -a
  . "$PLUGIN_DIR/.env"
  set +a
fi

TARGET="$AWB_LOCAL_PLUGIN_DIR"

if [ -z "$TARGET" ]; then
  echo "AWB_LOCAL_PLUGIN_DIR is not set. Copy .env.example to .env and set it." >&2
  exit 1
fi

# rsync runs with --delete, so only ever let it point at a plugins directory.
case "$TARGET" in
  */wp-content/plugins/*) ;;
  *)
    echo "Refusing to sync: '$TARGET' is not inside a wp-content/plugins directory." >&2
    exit 1
    ;;
esac

bash "$PLUGIN_DIR/bin/build-dist.sh"

echo "Syncing to $TARGET ..."
mkdir -p "$TARGET"
rsync -a --delete "$PLUGIN_DIR/dist/" "$TARGET/"

echo ""
echo "Done. Plugin synced to: $TARGET"
