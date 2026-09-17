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

```bash
git archive 2.0 | ssh hetzner 'D=$(mktemp -d); tar -x -C $D; sudo rsync -a --delete --chown=web_colorlibhub_com:web_colorlibhub_com $D/ /var/www/colorlibhub.com/public/wp-content/themes/tyche-2/; rm -rf $D'
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
