=== Tyche ===

Contributors: colorlib
Requires at least: 7.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.0.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: e-commerce, full-site-editing, block-patterns, block-styles, style-variations, template-editing, wide-blocks, custom-colors, custom-logo, custom-menu, editor-style, featured-images, one-column, two-columns, left-sidebar, translation-ready, threaded-comments

A WooCommerce block theme for fashion, lifestyle and independent stores.

== Description ==

Tyche is a free WooCommerce block theme. Every store page is designed and editable in the Site Editor:

* A sticky header with search, account and a slide-out cart, in four layouts.
* A shop with filters for price, category, rating and stock, a sticky filter sidebar, and product cards with add to cart over the photograph.
* A product page with a gallery, a summary that stays in view, variation selectors, delivery and returns promises, and details, specifications and reviews in accordions.
* A cart, a checkout with its own focused header, and an order confirmation page.
* Ten homepage sections: hero, category tiles, new arrivals, a best sellers carousel, brand story, promotions, store promises, reviews, journal posts and an account sign-up band.
* Complete page layouts for About, Contact, FAQ, Delivery and returns, and a Size guide, offered whenever you create a page.
* Eight colour palettes, each checked for readable contrast on every colour pair the design uses, and self-hosted fonts.

Tyche uses WooCommerce's own blocks, so it keeps working as WooCommerce improves them.

== Frequently Asked Questions ==

= Does Tyche need any plugins? =

Tyche is designed for WooCommerce and works without other plugins. The free Tyche Companion plugin adds store features a theme is not allowed to include: free shipping progress, a sticky add-to-cart bar, sale percentage and stock badges, and a second product photo on hover.

= I am updating from Tyche 1.x. What changes? =

Tyche 2.0 is a block theme. Your menus, logo, products and pages carry over. The 1.x homepage slider, front-page widget sections, colour schemes and Customizer options are no longer used. If Settings > Reading shows one of your pages as the front page, that page stays your homepage; add the "Store homepage" pattern to it to use the new design. Tyche 2.0 requires WordPress 7.0, so sites on older versions stay on Tyche 1.6.3 until WordPress is updated.

= Where is the Customizer? =

Block themes are edited in Appearance > Editor. Colours, fonts, the header, the footer and every template live there.

== Copyright ==

Tyche WordPress Theme, Copyright (C) 2017-2026 Colorlib.
Tyche is distributed under the terms of the GNU GPL v2 or later.

Tyche bundles the following third-party resources:

Instrument Serif
Copyright 2022 The Instrument Serif Project Authors (https://github.com/Instrument/instrument-serif)
License: SIL Open Font License 1.1, https://openfontlicense.org/

Figtree
Copyright 2022 The Figtree Project Authors (https://github.com/erikdkennedy/figtree)
License: SIL Open Font License 1.1, https://openfontlicense.org/

Tabler Icons (assets/icons)
Copyright (c) 2020-2026 Pawel Kuna
License: MIT, https://github.com/tabler/tabler-icons/blob/main/LICENSE

Photographs in assets/images
License: CC0 1.0 Universal, https://creativecommons.org/publicdomain/zero/1.0/
Source: StockSnap, https://stocksnap.io/license
* hero-1.webp: Lucas Defibaugh, https://stocksnap.io/photo/people-back-Q71CIRI83F
* promo-1.webp: Freestocks.org, https://stocksnap.io/photo/people-woman-YXR4DJ0MFG
* promo-2.webp: Freestocks.org, https://stocksnap.io/photo/girl-woman-KCY1MEEWD2
* cat-coats.webp: Matt Moloney, https://stocksnap.io/photo/woman-fashion-94TN6BQCV4
* cat-knitwear.webp: Beauty and Fashion, https://stocksnap.io/photo/woman-fashion-QGXSDEZ0FE
* cat-dresses.webp: Matt Bango, https://stocksnap.io/photo/woman-city-Z8KGNYGS8D
* cat-accessories.webp: Clem Onojeghuo, https://stocksnap.io/photo/brown-leather-9YGBJUD1FY
* story-1.webp: Alex Andrews, https://stocksnap.io/photo/stack-sheets-WNPRW5MEWD
* about-1.webp: Seacoast Sage, https://stocksnap.io/photo/tweed-suit-IAEXJXGTXE
* about-2.webp: Karen Cantu Q, https://stocksnap.io/photo/people-woman-L1IARTVGHE
* about-3.webp: Michal Kulesza, https://stocksnap.io/photo/clothes-sweaters-OA0AFM3HYZ
* about-4.webp: Elliott Chau, https://stocksnap.io/photo/walking-girl-XOIKTG7EVX
* contact-1.webp: Alvaro Serrano, https://stocksnap.io/photo/bag-leather-DQCQ6W96UC
* size-1.webp: Beauty and Fashion, https://stocksnap.io/photo/people-woman-FVLLWFVVHH
* avatar-1.webp: Candace McDaniel, https://stocksnap.io/photo/woman-model-TJHZP9PY4F
* avatar-2.webp: Kristin Hardwick, https://stocksnap.io/photo/black-portrait-T8VNJRQH7F
* avatar-3.webp: Candace McDaniel, https://stocksnap.io/photo/smiling-woman-GS765ITKWA

== Changelog ==

= 2.0.0 =
* Rebuilt as a WooCommerce block theme. Every page is edited in the Site Editor.
* New shop with filters, product page with gallery and accordions, cart drawer, focused checkout and order confirmation.
* Ten homepage sections, five page layouts and four header layouts.
* Eight colour palettes, checked for contrast, with self-hosted Instrument Serif and Figtree.
* Requires WordPress 7.0 and WooCommerce 11.
* Sites updating from 1.x see a notice explaining what carried over.

= 1.6.3 =
* Security: removed the legacy About screen, one of whose handlers let a logged-out visitor change the front page and posts page settings. Setup now lives in Appearance > Customize > Set up Tyche
* Fixed shop, category and product pages printing an unmatched closing </main></div>

= 1.6.2 =
* Fixed the social links menu showing blank icons: brand icons such as Facebook, Twitter and YouTube were being drawn from the solid icon font, which does not contain them
* Fixed the default share icon, shown for links that are not a known network, missing from the bundled icon subset
* Fixed every icon disappearing when the complete Font Awesome is enabled with the tyche_full_fontawesome filter
* Fixed the About screen caching a failed WordPress.org plugin lookup for 30 minutes and printing PHP warnings until it expired
* Stopped recommending KB Support, which WordPress.org closed for a security issue

= 1.6.1 =
* Removed the bundled Epsilon framework and the Kirki dependency; the customizer now runs on core WordPress APIs, so the theme needs no plugins
* Removed the colour-coded categories option, which came with the Epsilon framework
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
