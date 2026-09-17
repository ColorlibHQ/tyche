#!/usr/bin/env bash
#
# Regenerate everything and refuse to continue on any invalid block.
#
# The normaliser's own re-parse can pass markup that the Site Editor then flags
# (the comments block lost its wrapper and still "parsed clean"), so the
# validator, which reads templates, parts and patterns back through the REST API,
# is the gate. Run this before every commit.
#
#   WP_URL=http://localhost:8812 WP_USER=admin WP_PASS=admin123 bash .dev/check.sh
set -euo pipefail
cd "$( dirname "$0" )/.."

: "${WP_URL:=http://localhost:8812}" "${WP_USER:=admin}" "${WP_PASS:=admin123}"
export WP_URL WP_USER WP_PASS

python3 .dev/build_theme.py > /dev/null
python3 .dev/build_patterns.py
node .dev/normalize-blocks.mjs | tail -2

# After the normaliser, not before it. Re-serialising a block escapes what it
# does not recognise, and that is what turned a pattern's PHP into a parse error
# that a lint of the generated file had already passed.
for f in patterns/*.php parts/*.html templates/*.html inc/*.php functions.php; do
	case "$f" in
		*.php) php -l "$f" > /dev/null ;;
		*) grep -q '<?php' "$f" && { echo "PHP in $f, which is not executed"; exit 1; } || true ;;
	esac
done
node .dev/validate-blocks.mjs
