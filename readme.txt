=== Tyche ===

Contributors: colorlib
Requires at least: 5.2
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.6.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: e-commerce, custom-logo, two-columns, left-sidebar, right-sidebar, custom-header, custom-menu, featured-images, threaded-comments, footer-widgets, sticky-post, theme-options

== Description ==

Tyche is a free WooCommerce theme for building a real online shop. It ships a full-width
hero slider, product carousels, category and sale widgets, a live mini-cart in the header,
and shop, product, cart, checkout and account pages that follow WooCommerce's own
templates.

Tyche requires no other plugins to configure: the customizer is built on core WordPress
APIs, with no bundled framework and no companion plugin. It supports the block editor
through theme.json, block patterns and custom block styles, self-hosts its webfonts and
icons, and its carousel honours prefers-reduced-motion.

Free for personal and commercial use under the GPL.

== Translation ==
Theme can be translated directly on https://translate.wordpress.org/projects/wp-themes/tyche without relying on the .po file. All the translatable strings are pulled automatically. For more info please check this link https://make.wordpress.org/polyglots/handbook/tools/glotpress-translate-wordpress-org/

= License =

Tyche WordPress theme, Copyright (C) 2017 colorlib.com
Tyche WordPress theme is licensed under the GPL3.

Unless otherwise specified, all the theme files, scripts and images are licensed under GNU General Public License. The exceptions to this license are as follows:

=== Scripts ===

- Bootstrap v3.3.4 (http://getbootstrap.com)
    -- Copyright 2011-2016 Twitter, Inc.
    -- Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
- Font Awesome 7 Free
    -- Copyright Fonticons, Inc. - https://fontawesome.com
    -- Icons: CC BY 4.0 (https://creativecommons.org/licenses/by/4.0/)
    -- Fonts: SIL OFL 1.1 (https://scripts.sil.org/OFL)
    -- Code: MIT License (https://opensource.org/licenses/MIT)
- AdSense Loader
		-- A JavaScript plugin for lazy-loading responsive Google Adsense ads.
		-- By Osvaldas Valutis, www.osvaldas.info Available for use under the MIT License
- jQuery Zoom
		-- Zoom 1.7.20 http://www.jacklmoore.com/zoom 
    -- license: MIT
- Menu
    -- https://github.com/eumatheusgomes/menu
    -- license: MIT https://github.com/eumatheusgomes/menu/blob/master/bower.json#L15
    
=== Fonts ===

- Karla (self-hosted in assets/fonts)
    -- Copyright The Karla Project Authors - https://github.com/googlefonts/karla
    -- License: SIL OFL 1.1
    -- URL: https://scripts.sil.org/OFL

=== Images ===

- Images from assets/images are created by Colorlib unless otherwise specified
- assets/images/banner.jpg image License can be found here: https://pxhere.com/en/photo/849323
- assets/images/hero.jpg image License can be found here: https://pxhere.com/en/photo/761299
- assets/logo.png designed/created by Colorlib
- https://pxhere.com/en/photo/609722 - used for screenshot
- https://pxhere.com/en/photo/1634252 - used for screenshot
- https://pxhere.com/en/photo/708775 - used for screenshot
- https://pxhere.com/en/photo/639769 - used for screenshot
- https://pxhere.com/en/photo/849323 - used for screenshot
- https://pxhere.com/en/photo/761299 - used for screenshot
- The demo shop photography is not distributed with the theme. Only the images listed
  above ship in the package.

== Changelog ==

= 1.6.1 =
* Removed the bundled Epsilon framework and the Kirki dependency; the customizer now runs on core WordPress APIs, so the theme needs no plugins
* Replaced Owl Carousel with a dependency-free carousel that honours prefers-reduced-motion
* Added theme.json, block patterns and block styles for the block editor
* Added a native Recommended Actions panel with live-checked setup steps
* Dropped six WooCommerce template overrides that were frozen at WooCommerce 3.3
* Self-hosted the webfonts and updated to Font Awesome 7
* Fixed the welcome screen loading translations before init
* Fixed the products widget rendering two cart icons
* Fixed slider and banner images stored as URLs not rendering after upgrade
* Versioned every theme asset with the theme version so updates reach browsers

= 1.6.0 =
* Feature requests #28

= 1.5.0 =
* Maintenance update

= 1.1.2 =
* See the milestone on GitHub: https://github.com/ColorlibHQ/tyche/milestone/1?closed=1

= 1.1.1 =
* Fixed security issue

= 1.1.0 =
* Fixed Tyche icons
* Added settings for number of columns and products per page
* Added control to disable product zoom on hover
* Added real time update of minicart
* Added option to translate slider text
* Updated WooCommerce files
* Fixed: hide out of stock products
