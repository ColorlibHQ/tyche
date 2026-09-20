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

# The stylesheet header, the readme's stable tag and TYCHE_VERSION have to say
# the same thing. TYCHE_VERSION is what every asset URL carries, and those URLs
# are served immutable for a year: bump the header alone and the new CSS reaches
# nobody who has already visited, which is how a fixed release can look unfixed.
# wordpress.org also refuses a stable tag that disagrees with the header.
style_version=$( sed -n 's/^Version: *//p' style.css | head -1 | tr -d '\r' )
readme_version=$( sed -n 's/^Stable tag: *//p' readme.txt | head -1 | tr -d '\r' )
php_version=$( sed -n "s/.*TYCHE_VERSION', *'\([^']*\)'.*/\1/p" functions.php | head -1 )
if [ "$style_version" != "$readme_version" ] || [ "$style_version" != "$php_version" ]; then
	echo "version mismatch: style.css $style_version, readme.txt $readme_version, TYCHE_VERSION $php_version"
	exit 1
fi

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
