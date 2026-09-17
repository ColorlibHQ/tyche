# The 2.0 preview store

https://colorlibhub.com/tyche-2/ (blog 112 on the colorlibhub multisite).

A separate site, so the live 1.x demo at /tyche/ keeps matching the version
people download. The theme is installed as `wp-content/themes/tyche-2` for the
same reason: `tyche` is the 1.x theme that demo uses.

- `seed.php` builds the store: settings, a US shipping zone (free over $75, the
  amount the theme's copy promises), 19 products with photographs and a variable
  product, reviews, the page patterns as pages, a static front page, the journal
  and the menu. It is safe to re-run.
- `tyche-2-demo.php` is a network mu-plugin that refuses the checkout's
  place-order request on this site only, so visitors can go through checkout
  without an order or their address ever being stored.

## Redeploying the theme and plugin

Bump `TYCHE_VERSION` and the `Version:` header first: assets are cached by
their `?ver=` string, so an unchanged version keeps serving the old CSS.

```bash
git archive 2.0 | ssh hetzner 'D=$(mktemp -d); tar -x -C $D; sudo rsync -a --delete --chmod=D755,F644 --chown=web_colorlibhub_com:web_colorlibhub_com $D/ /var/www/colorlibhub.com/public/wp-content/themes/tyche-2/; rm -rf $D'
```

`--chmod` matters. `mktemp -d` makes a 700 directory and `rsync -a` copies that
mode onto the theme directory, which leaves nginx unable to read any theme file:
every stylesheet returns 403 and the store renders unstyled. That happened on
2026-09-17. Check afterwards in a browser, not with curl -- Cloudflare answers a
bare curl for theme assets with its own 403 whatever the file's state:

```bash
# expect 200 for style.css and woocommerce.css
node -e "const {chromium}=require('playwright');(async()=>{const b=await chromium.launch();const p=await b.newPage();p.on('response',r=>/themes\/tyche-2\/.*\.css/.test(r.url())&&console.log(r.status(),r.url()));await p.goto('https://colorlibhub.com/tyche-2/');await b.close()})()"
```

Then purge this site's FastCGI entries:

```bash
ssh hetzner 'sudo grep -rl "KEY: httpsGETcolorlibhub.com/tyche-2" /var/cache/nginx | sudo xargs -r rm -f'
```

## Re-running the seed

The photographs are not in this repository. They are CC0 files from StockSnap, listed with their
sources in `readme.txt` (theme images) and cropped for products by hand. Upload
them to a directory on the server, then:

```bash
sudo -u web_colorlibhub_com wp eval-file seed.php /path/to/assets \
  --url=https://colorlibhub.com/tyche-2/ --skip-plugins=google-maps
```

WP-CLI runs as `web_colorlibhub_com`, the PHP-FPM user. The site's upload
directory has to be writable by it: `uploads/sites` belongs to `www-data`, so a new
site's directory is created with `install -d -o web_colorlibhub_com -g www-data -m 775`.
