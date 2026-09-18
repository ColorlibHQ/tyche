#!/usr/bin/env bash
#
# Build the distributable theme zip.
#
# Ships only what a site needs to run: the generators in .dev/, the repo's own
# CLAUDE.md and the git history stay behind. Theme Check must be run against
# THIS output, not the working tree, or it reports on the tooling as well.
#
# Usage:  bash .dev/build-zip.sh [outdir]
set -euo pipefail

here="$( cd "$( dirname "$0" )/.." && pwd )"
out="${1:-/tmp/tyche-build}"
name="tyche"

rm -rf "$out"
mkdir -p "$out/$name"

cd "$here"
rsync -a \
	--exclude '.*' \
	--exclude 'CLAUDE.md' \
	--exclude 'node_modules' \
	./ "$out/$name/"

cd "$out"
zip -rq "$name.zip" "$name"

echo "$out/$name.zip"
du -sh "$out/$name" "$out/$name.zip" | sed 's/^/  /'
