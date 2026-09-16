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
for f in patterns/*.php inc/*.php functions.php; do
	php -l "$f" > /dev/null
done
node .dev/normalize-blocks.mjs | tail -2
node .dev/validate-blocks.mjs
