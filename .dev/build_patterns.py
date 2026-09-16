#!/usr/bin/env python3
"""Generate Tyche's parts, templates and patterns.

Run from anywhere:

    python3 .dev/build_patterns.py
    node .dev/normalize-blocks.mjs      # the editor re-serialises every pattern
    node .dev/validate-blocks.mjs       # and anything still invalid fails

Nothing in parts/, templates/ or patterns/ is edited by hand.

Templates are thin: a header part, one hidden pattern, a footer part. The
markup lives in patterns because patterns are PHP -- so every visible string can
go through the translation functions WordPress.org requires, links to the shop
or account page resolve at render time, and the normaliser can put the markup
through the real block serialiser.

Store blocks whose inner blocks are built by the editor (Product Filters, the
product gallery, product details, the carousel) come from .dev/captured/,
written by capture-blocks.mjs from a real editor session.
"""

import json
import os
import re
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from patternlib import attrs  # noqa: E402

HERE = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(HERE)
WRITTEN = []

STORE = ["tyche-store"]
CONTENT = ["tyche-content"]
PAGES = ["tyche-pages"]


# ---------------------------------------------------------------------------
# PHP snippets
# ---------------------------------------------------------------------------
def _php(text):
    return text.replace("\\", "\\\\").replace("'", "\\'")


def t(text):
    """Translatable plain text."""
    return "<?php esc_html_e( '%s', 'tyche' ); ?>" % _php(text)


def tk(text):
    """Translatable text that carries inline markup such as <strong>."""
    return "<?php echo wp_kses_post( __( '%s', 'tyche' ) ); ?>" % _php(text)


def ta(text):
    """Translatable text inside an HTML attribute."""
    return "<?php esc_attr_e( '%s', 'tyche' ); ?>" % _php(text)


def img(slug):
    return "<?php echo esc_url( get_theme_file_uri( 'assets/images/%s.jpg' ) ); ?>" % slug


def url(page):
    return "<?php echo esc_url( tyche_store_url( '%s' ) ); ?>" % page


HOME = "<?php echo esc_url( home_url( '/' ) ); ?>"
IF_WOO = "<?php if ( tyche_has_woocommerce() ) : ?>"
END_IF = "<?php endif; ?>"


# ---------------------------------------------------------------------------
# Block helpers
# ---------------------------------------------------------------------------
def block(name, data=None, inner=None):
    """Any block. `inner` of None makes it self-closing."""
    if inner is None:
        return "<!-- wp:%s%s /-->" % (name, attrs(data))
    return "<!-- wp:%s%s -->\n%s\n<!-- /wp:%s -->" % (name, attrs(data), inner, name)


def _classes(*names):
    return " ".join(n for n in names if n)


def group(inner, cls=None, tag="div", layout="constrained", align=None, bg=None, color=None,
          pad=None, gap=None, justify=None, orientation=None, wrap=None, content_size=None,
          font=None, margin_top=None, style=None):
    data = {}
    css = []
    classes = ["wp-block-group"]
    if tag != "div":
        data["tagName"] = tag
    if align:
        data["align"] = align
        classes.append("align" + align)
    if cls:
        data["className"] = cls
        classes.append(cls)
    if bg:
        data["backgroundColor"] = bg
        classes += ["has-%s-background-color" % bg, "has-background"]
    if color:
        data["textColor"] = color
        classes += ["has-%s-color" % color, "has-text-color"]
    if font:
        data["fontSize"] = font
        classes.append("has-%s-font-size" % font)
    st = dict(style or {})
    if pad:
        top, bottom = (pad, pad) if isinstance(pad, str) else pad
        st.setdefault("spacing", {})["padding"] = {"top": "var:preset|spacing|" + top,
                                                   "bottom": "var:preset|spacing|" + bottom}
        css += ["padding-top:var(--wp--preset--spacing--%s)" % top,
                "padding-bottom:var(--wp--preset--spacing--%s)" % bottom]
    if margin_top is not None:
        st.setdefault("spacing", {})["margin"] = {"top": margin_top}
        css.append("margin-top:%s" % margin_top)
    if gap:
        st.setdefault("spacing", {})["blockGap"] = "var:preset|spacing|" + gap
    if st:
        data["style"] = st
    lay = {"type": layout}
    if content_size:
        lay["contentSize"] = content_size
    if justify:
        lay["justifyContent"] = justify
    if orientation:
        lay["orientation"] = orientation
    if wrap:
        lay["flexWrap"] = wrap
    data["layout"] = lay
    style_attr = ' style="%s"' % ";".join(css) if css else ""
    return "<!-- wp:group%s -->\n<%s class=\"%s\"%s>\n%s\n</%s>\n<!-- /wp:group -->" % (
        attrs(data), tag, _classes(*classes), style_attr, inner, tag)


def heading(text, level=2, cls=None, align=None, size=None, color=None, family=None):
    data = {}
    classes = ["wp-block-heading"]
    if level != 2:
        data["level"] = level
    if align:
        data["textAlign"] = align
        classes.append("has-text-align-" + align)
    if cls:
        data["className"] = cls
        classes.append(cls)
    if color:
        data["textColor"] = color
        classes += ["has-%s-color" % color, "has-text-color"]
    if size:
        data["fontSize"] = size
        classes.append("has-%s-font-size" % size)
    if family:
        data["fontFamily"] = family
        classes.append("has-%s-font-family" % family)
    return "<!-- wp:heading%s -->\n<h%d class=\"%s\">%s</h%d>\n<!-- /wp:heading -->" % (
        attrs(data), level, _classes(*classes), text, level)


def para(text, cls=None, align=None, size=None, color=None):
    data = {}
    classes = []
    if align:
        data["align"] = align
        classes.append("has-text-align-" + align)
    if cls:
        data["className"] = cls
        classes.append(cls)
    if color:
        data["textColor"] = color
        classes += ["has-%s-color" % color, "has-text-color"]
    if size:
        data["fontSize"] = size
        classes.append("has-%s-font-size" % size)
    class_attr = ' class="%s"' % _classes(*classes) if classes else ""
    return "<!-- wp:paragraph%s -->\n<p%s>%s</p>\n<!-- /wp:paragraph -->" % (attrs(data), class_attr, text)


def eyebrow(text, color=None, align=None):
    return para(text, cls="is-style-tyche-eyebrow", color=color, align=align)


def button(text, href, style=None, bg=None, color=None):
    data = {}
    classes = ["wp-block-button"]
    link = ["wp-block-button__link"]
    if style:
        data["className"] = "is-style-" + style
        classes.append("is-style-" + style)
    if bg:
        data["backgroundColor"] = bg
        link += ["has-%s-background-color" % bg, "has-background"]
    if color:
        data["textColor"] = color
        link += ["has-%s-color" % color, "has-text-color"]
    link.append("wp-element-button")
    return ("<!-- wp:button%s -->\n<div class=\"%s\"><a class=\"%s\" href=\"%s\">%s</a></div>\n"
            "<!-- /wp:button -->" % (attrs(data), _classes(*classes), _classes(*link), href, text))


def buttons(*items, justify=None):
    data = {}
    if justify:
        data["layout"] = {"type": "flex", "justifyContent": justify}
    return "<!-- wp:buttons%s -->\n<div class=\"wp-block-buttons\">\n%s\n</div>\n<!-- /wp:buttons -->" % (
        attrs(data), "\n".join(items))


def columns(*cols, cls=None, align=None, gap=None, valign=None):
    data = {}
    classes = ["wp-block-columns"]
    if align:
        data["align"] = align
        classes.append("align" + align)
    if cls:
        data["className"] = cls
        classes.append(cls)
    if valign:
        data["verticalAlignment"] = valign
        classes.append("are-vertically-aligned-" + valign)
    if gap:
        data["style"] = {"spacing": {"blockGap": {"top": "var:preset|spacing|" + gap,
                                                  "left": "var:preset|spacing|" + gap}}}
    return "<!-- wp:columns%s -->\n<div class=\"%s\">\n%s\n</div>\n<!-- /wp:columns -->" % (
        attrs(data), _classes(*classes), "\n".join(cols))


def column(inner, width=None, cls=None, valign=None):
    data = {}
    classes = ["wp-block-column"]
    css = ""
    if valign:
        data["verticalAlignment"] = valign
        classes.append("is-vertically-aligned-" + valign)
    if width:
        data["width"] = width
        css = ' style="flex-basis:%s"' % width
    if cls:
        data["className"] = cls
        classes.append(cls)
    return "<!-- wp:column%s -->\n<div class=\"%s\"%s>\n%s\n</div>\n<!-- /wp:column -->" % (
        attrs(data), _classes(*classes), css, inner)


def image(slug, alt, ratio=None, cls=None):
    data = {"sizeSlug": "large", "linkDestination": "none"}
    style = ""
    if ratio:
        data = {"aspectRatio": ratio, "scale": "cover", "sizeSlug": "large", "linkDestination": "none"}
        style = ' style="aspect-ratio:%s;object-fit:cover"' % ratio
    classes = ["wp-block-image", "size-large"]
    if cls:
        data["className"] = cls
        classes.append(cls)
    return ("<!-- wp:image%s -->\n<figure class=\"%s\"><img src=\"%s\" alt=\"%s\"%s/></figure>\n"
            "<!-- /wp:image -->" % (attrs(data), _classes(*classes), img(slug), alt, style))


# Text on a photograph sits at the bottom of every cover in the theme, so the
# darkening sits there too. A flat dim light enough to keep the photograph
# lively left white text at 3.3:1 on a pale knitwear shot; a gradient keeps the
# top of the picture untouched and the text on a dark ground whatever the photo.
SCRIM = "linear-gradient(180deg,rgba(12,10,8,0) 30%,rgba(12,10,8,0.72) 100%)"
SCRIM_SIDE = "linear-gradient(90deg,rgba(12,10,8,0.62) 0%,rgba(12,10,8,0.18) 60%,rgba(12,10,8,0) 100%)"


def cover(inner, slug, dim=30, min_height=None, unit="px", position=None, cls=None, ratio=None,
          overlay="dark", align=None, gradient=None):
    data = {"url": "TYCHE_IMAGE", "dimRatio": dim, "overlayColor": overlay, "isUserOverlayColor": True}
    if gradient:
        data = {"url": "TYCHE_IMAGE", "dimRatio": 100, "customGradient": gradient, "isUserOverlayColor": True}
    classes = ["wp-block-cover"]
    css = []
    if min_height:
        data["minHeight"] = min_height
        data["minHeightUnit"] = unit
        css.append("min-height:%s%s" % (min_height, unit))
    if position:
        data["contentPosition"] = position
        classes += ["has-custom-content-position", "is-position-" + position.replace(" ", "-")]
    if align:
        data["align"] = align
        classes.append("align" + align)
    if cls:
        data["className"] = cls
        classes.append(cls)
    if ratio:
        data["style"] = {"dimensions": {"aspectRatio": ratio}}
    data["layout"] = {"type": "constrained"}
    style_attr = ' style="%s"' % ";".join(css) if css else ""
    if gradient:
        span = ('<span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 '
                'has-background-dim wp-block-cover__gradient-background has-background-gradient" '
                'style="background:%s"></span>' % gradient)
    else:
        span = ('<span aria-hidden="true" class="wp-block-cover__background has-%s-background-color '
                'has-background-dim-%d has-background-dim"></span>' % (overlay, 10 * round(dim / 10)))
    comment = attrs(data).replace('"TYCHE_IMAGE"', '"%s"' % img(slug))
    return ("<!-- wp:cover%s -->\n<div class=\"%s\"%s><img class=\"wp-block-cover__image-background\" "
            "alt=\"\" src=\"%s\" data-object-fit=\"cover\"/>%s<div class=\"wp-block-cover__inner-container\">\n"
            "%s\n</div></div>\n<!-- /wp:cover -->" % (comment, _classes(*classes), style_attr, img(slug), span, inner))


def icon(name, label=None, cls="tyche-icon"):
    data = {"icon": name}
    if label:
        data["ariaLabel"] = label
    if cls:
        data["className"] = cls
    return block("icon", data)


def check_list(*items):
    li = "\n".join("<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->" % i for i in items)
    return ("<!-- wp:list {\"className\":\"is-style-tyche-checks\"} -->\n"
            "<ul class=\"wp-block-list is-style-tyche-checks\">\n%s\n</ul>\n<!-- /wp:list -->" % li)


def pattern_ref(slug):
    return block("pattern", {"slug": "tyche/" + slug})


def captured(name, translations=None):
    with open(os.path.join(HERE, "captured", name + ".html"), encoding="utf-8") as fh:
        markup = fh.read().strip()
    for english in translations or ():
        markup = markup.replace(">%s<" % english, ">%s<" % t(english))
    return markup


# ---------------------------------------------------------------------------
# Section scaffolding
# ---------------------------------------------------------------------------
def section(inner, cls=None, bg=None, color=None, pad="70", tag="section"):
    """A full-width band. Top and bottom padding only: root padding supplies the sides."""
    return group(inner, cls=_classes("tyche-section", cls), tag=tag, align="full", bg=bg, color=color, pad=pad)


def section_head(title, kicker=None, link_text=None, link_href=None, extra=None, level=2):
    left = []
    if kicker:
        left.append(eyebrow(kicker))
    left.append(heading(title, level=level))
    right = []
    if link_text:
        right.append(buttons(button(link_text, link_href, style="tyche-link")))
    if extra:
        right.append(extra)
    inner = group("\n".join(left), cls="tyche-section-head__title", layout="flex", orientation="vertical", gap="20")
    if right:
        inner += "\n" + group("\n".join(right), cls="tyche-section-head__actions", layout="flex", wrap="nowrap")
    return group(inner, cls="tyche-section-head", align="wide", layout="flex", justify="space-between",
                 wrap="wrap")


# ---------------------------------------------------------------------------
# Products
# ---------------------------------------------------------------------------
COLLECTIONS = {
    "new-arrivals": {"orderBy": "date", "order": "desc"},
    "best-sellers": {"orderBy": "popularity", "order": "desc"},
    "on-sale": {"orderBy": "date", "order": "desc", "woocommerceOnSale": True},
    "featured": {"orderBy": "date", "order": "desc", "featured": True},
    "top-rated": {"orderBy": "rating", "order": "desc"},
}


def product_card(carousel=False):
    """The one product card. Every grid, row and carousel in the theme uses it.

    DOM order is image, title, price, button -- the order a keyboard or screen
    reader meets them. The stylesheet lifts the button over the photograph with
    a grid area, so the visual overlay never reorders the page.
    """
    template = {"className": "tyche-product-cards"}
    if carousel:
        template["layout"] = {"type": "flex", "justifyContent": "left", "verticalAlignment": "top",
                              "flexWrap": "nowrap", "orientation": "horizontal"}
    inner = "\n\n".join([
        block("woocommerce/product-image",
              {"showSaleBadge": False, "imageSizing": "single", "isDescendentOfQueryLoop": True,
               "className": "tyche-card-media", "style": {"dimensions": {"aspectRatio": "4/5"}}},
              block("woocommerce/product-sale-badge", {"isDescendentOfQueryLoop": True, "align": "left"})),
        block("post-title", {"level": 3, "isLink": True, "className": "tyche-card-title",
                             "__woocommerceNamespace": "woocommerce/product-collection/product-title"}),
        block("woocommerce/product-price", {"isDescendentOfQueryLoop": True, "className": "tyche-card-price"}),
        block("woocommerce/product-button", {"isDescendentOfQueryLoop": True, "className": "tyche-card-button"}),
    ])
    return block("woocommerce/product-template", template, inner)


def no_results():
    return block("woocommerce/product-collection-no-results", None, group(
        "\n".join([
            heading(t("Nothing matches those filters"), level=3, size="x-large"),
            para(t("Try removing a filter, or browse everything in the shop."), color="muted"),
            buttons(button(t("Clear filters and browse"), url("shop"), style="tyche-outline")),
        ]), layout="flex", orientation="vertical", gap="30", cls="tyche-no-results"))


def product_collection(collection=None, per_page=4, cols=4, carousel=False, inherit=False,
                       pagination=False, related=False, align="wide", filterable=False):
    query = {"perPage": per_page, "pages": 0, "offset": 0, "postType": "product", "order": "asc",
             "orderBy": "title", "search": "", "exclude": [], "inherit": inherit, "taxQuery": {},
             "isProductCollectionBlock": True, "featured": False, "woocommerceOnSale": False,
             "woocommerceStockStatus": ["instock", "outofstock", "onbackorder"],
             "woocommerceAttributes": [], "woocommerceHandPickedProducts": []}
    if filterable:
        query["filterable"] = True
    if collection in COLLECTIONS:
        query.update(COLLECTIONS[collection])
    if related:
        query["relatedBy"] = {"categories": True, "tags": True}
    data = {"queryId": 0, "query": query, "tagName": "div",
            "displayLayout": {"type": "carousel" if carousel else "flex", "columns": cols, "shrinkColumns": True},
            "dimensions": {"widthType": "fill"}, "queryContextIncludes": ["collection"],
            "className": "tyche-products" + (" is-carousel" if carousel else "")}
    if collection:
        data["collection"] = "woocommerce/product-collection/" + collection
    if align:
        data["align"] = align
    parts = []
    if carousel:
        parts.append(group(block("woocommerce/product-gallery-large-image-next-previous",
                                 {"layout": {"type": "flex", "flexWrap": "nowrap"}},
                                 '<div class="wp-block-woocommerce-product-gallery-large-image-next-previous"></div>'),
                           cls="tyche-carousel-nav", layout="flex", wrap="nowrap", justify="right"))
    parts.append(product_card(carousel))
    if pagination:
        parts.append(block("query-pagination", {"paginationArrow": "arrow", "layout": {"type": "flex", "justifyContent": "center"}},
                           "\n".join([block("query-pagination-previous"), block("query-pagination-numbers"),
                                      block("query-pagination-next")])))
    parts.append(no_results())
    classes = "wp-block-woocommerce-product-collection" + (" align" + align if align else "")
    return "<!-- wp:woocommerce/product-collection%s -->\n<div class=\"%s\">\n%s\n</div>\n<!-- /wp:woocommerce/product-collection -->" % (
        attrs(data), classes, "\n\n".join(parts))


# ---------------------------------------------------------------------------
# Writers
# ---------------------------------------------------------------------------
def write_pattern(slug, title, content, categories=None, keywords=None, description=None,
                  inserter=True, block_types=None, template_types=None, viewport=1400, post_types=None):
    header = ["Title: " + title, "Slug: tyche/" + slug]
    if categories:
        header.append("Categories: " + ", ".join(categories))
    if keywords:
        header.append("Keywords: " + ", ".join(keywords))
    if block_types:
        header.append("Block Types: " + ", ".join(block_types))
    if template_types:
        header.append("Template Types: " + ", ".join(template_types))
    if post_types:
        header.append("Post Types: " + ", ".join(post_types))
    if description:
        header.append("Description: " + description)
    header.append("Viewport Width: %d" % viewport)
    if not inserter:
        header.append("Inserter: no")
    body = ("<?php\n/**\n * " + "\n * ".join(header) + "\n *\n * @package Tyche\n */\n\n"
            "defined( 'ABSPATH' ) || exit;\n?>\n" + content.strip() + "\n")
    path = os.path.join(ROOT, "patterns", slug + ".php")
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, "w", encoding="utf-8") as fh:
        fh.write(body)
    WRITTEN.append("patterns/%s.php" % slug)


def write_file(rel, content):
    path = os.path.join(ROOT, rel)
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, "w", encoding="utf-8") as fh:
        fh.write(content.strip() + "\n")
    WRITTEN.append(rel)


def page_template(body_slug, header="header", footer="footer"):
    out = [block("template-part", {"slug": header, "tagName": "header", "className": "tyche-site-header"})]
    out.append(pattern_ref(body_slug))
    if footer:
        out.append(block("template-part", {"slug": footer, "tagName": "footer"}))
    return "\n\n".join(out)


def main_group(inner, pad=("50", "80"), cls=None, content_size=None):
    return group(inner, tag="main", cls=_classes("tyche-main", cls), pad=pad, content_size=content_size,
                 margin_top="0")


# ---------------------------------------------------------------------------
# Header and footer
# ---------------------------------------------------------------------------
def header_pattern():
    announcement = group(
        para(tk('Free delivery on orders over $75 &middot; Free 30-day returns') +
             ' <a href="%s">%s</a>' % (url("shop"), t("Shop new in")), align="center", size="small"),
        cls="tyche-announcement", align="full", bg="dark", color="on-dark", pad="20")

    nav = block("navigation", {"overlayMenu": "mobile", "className": "tyche-header__nav",
                               "layout": {"type": "flex", "justifyContent": "left"},
                               "style": {"spacing": {"blockGap": "var:preset|spacing|40"}}})
    brand = group("\n".join([
        block("site-logo", {"width": 120, "shouldSyncIcon": False}),
        block("site-title", {"level": 0}),
    ]), cls="tyche-header__brand", layout="flex", wrap="nowrap", justify="center")

    # The account and cart blocks only exist with WooCommerce. A PHP condition
    # cannot sit between blocks inside a group -- re-serialising drops it -- so
    # the condition lives at the top level of its own small pattern.
    write_pattern("header-store-actions", "Header store icons", "\n".join([
        IF_WOO,
        block("woocommerce/customer-account", {"displayStyle": "icon_only", "iconStyle": "line",
                                               "iconClass": "wc-block-customer-account__account-icon",
                                               "className": "tyche-header__account"}),
        block("woocommerce/mini-cart", {"miniCartIcon": "bag", "addToCartBehaviour": "open_drawer",
                                        "hasHiddenPrice": True, "className": "tyche-header__cart"}),
        END_IF,
    ]), inserter=False)
    actions = "\n".join([
        block("search", {"label": "SEARCH_LABEL", "showLabel": False, "placeholder": "SEARCH_PLACEHOLDER",
                         "buttonText": "SEARCH_LABEL", "buttonPosition": "button-only", "buttonUseIcon": True,
                         "query": {"post_type": "product"}, "className": "tyche-header__search"}),
        pattern_ref("header-store-actions"),
    ])
    actions = group(actions, cls="tyche-header__actions", layout="flex", wrap="nowrap", justify="right", gap="30")
    bar = group("\n".join([nav, brand, actions]), cls="tyche-header__bar", align="wide", layout="flex",
                wrap="nowrap", justify="space-between")
    main = group(bar, cls="tyche-header", align="full", bg="base", pad="30")
    content = announcement + "\n\n" + main
    content = content.replace('"SEARCH_LABEL"', '"%s"' % "<?php echo esc_attr__( 'Search', 'tyche' ); ?>")
    content = content.replace('"SEARCH_PLACEHOLDER"', '"%s"' % "<?php echo esc_attr__( 'Search products', 'tyche' ); ?>")
    write_pattern("header", "Header with announcement bar", content, inserter=False,
                  block_types=["core/template-part/header"])


def footer_links(title, items):
    links = "\n".join(block("navigation-link", {"label": label, "url": "#", "kind": "custom", "isTopLevelLink": True})
                      for label in items)
    nav = block("navigation", {"overlayMenu": "never", "className": "tyche-footer__links",
                               "layout": {"type": "flex", "orientation": "vertical"},
                               "style": {"spacing": {"blockGap": "var:preset|spacing|20"}}}, links)
    return column("\n".join([heading(t(title), level=2, cls="tyche-footer__heading"), nav]))


def footer_pattern():
    brand = column("\n".join([
        block("site-title", {"level": 0, "className": "tyche-footer__title"}),
        para(t("Considered clothing and everyday essentials, made to be worn for years and shipped with care."),
             cls="tyche-footer__about"),
        block("social-links", {"iconColor": "overlay", "iconColorValue": "#ffffff", "size": "has-normal-icon-size",
                               "className": "is-style-logos-only tyche-footer__social",
                               "layout": {"type": "flex"}},
              "<ul class=\"wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only tyche-footer__social\">\n%s\n</ul>"
              % "\n".join(block("social-link", {"url": "#", "service": s}) for s in ("instagram", "pinterest", "tiktok", "facebook"))),
    ]), width="36%")
    top = columns(
        brand,
        footer_links("Shop", ["New arrivals", "Best sellers", "Sale", "Gift cards"]),
        footer_links("Help", ["Delivery", "Returns & exchanges", "Size guide", "Contact us"]),
        footer_links("About", ["Our story", "Journal", "Sustainability", "Stores"]),
        cls="tyche-footer__columns", align="wide", gap="60")
    write_pattern("footer-payments", "Footer payment icons", "\n".join([
        IF_WOO, block("woocommerce/payment-method-icons", {"className": "tyche-footer__payments"}), END_IF,
    ]), inserter=False)
    year = "<?php echo esc_html( gmdate( 'Y' ) ); ?>"
    bottom = group("\n".join([
        para("&copy; %s <?php bloginfo( 'name' ); ?>. %s" % (year, t("All rights reserved.")), size="small",
             cls="tyche-footer__legal"),
        pattern_ref("footer-payments"),
    ]), cls="tyche-footer__bottom", align="wide", layout="flex", justify="space-between", wrap="wrap")
    content = group(top + "\n\n" + block("separator", {"align": "wide", "className": "is-style-wide tyche-footer__rule"},
                                          '<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide tyche-footer__rule"/>')
                    + "\n\n" + bottom,
                    cls="tyche-footer", align="full", bg="dark", color="on-dark", pad=("70", "40"))
    write_pattern("footer", "Footer with link columns", content, inserter=False,
                  block_types=["core/template-part/footer"])


def checkout_header_pattern():
    back = para('<a href="%s">%s</a>' % (url("cart"), t("Back to cart")), cls="tyche-checkout-header__back",
                size="small")
    brand = group(block("site-logo", {"width": 120, "shouldSyncIcon": False}) + "\n" + block("site-title", {"level": 0}),
                  cls="tyche-header__brand", layout="flex", wrap="nowrap", justify="center")
    secure = group(icon("tyche/lock") + "\n" + para(t("Secure checkout"), size="small"),
                   cls="tyche-checkout-header__secure", layout="flex", wrap="nowrap", justify="right", gap="20")
    bar = group("\n".join([back, brand, secure]), cls="tyche-header__bar", align="wide", layout="flex",
                wrap="nowrap", justify="space-between")
    write_pattern("checkout-header", "Checkout header", group(bar, cls="tyche-header tyche-checkout-header",
                                                              align="full", bg="base", pad="30"),
                  inserter=False, block_types=["core/template-part/header"])


# ---------------------------------------------------------------------------
# Store pages
# ---------------------------------------------------------------------------
FILTER_WORDS = ["Filters", "Clear filters", "Price", "Rating", "Category", "Availability"]


def shop_body(search=False):
    title = block("query-title", {"type": "search" if search else "archive", "showPrefix": False,
                                  "level": 1, "className": "tyche-page-title"})
    head = group("\n".join([
        block("woocommerce/breadcrumbs", {"fontSize": "small"}),
        title,
        block("term-description", {"className": "tyche-term-description"}) if not search else "",
    ]), cls="tyche-page-head", align="wide", layout="flex", orientation="vertical", gap="20")
    toolbar = group("\n".join([
        block("woocommerce/product-results-count"),
        block("woocommerce/catalog-sorting"),
    ]), cls="tyche-shop__toolbar", layout="flex", justify="space-between", wrap="wrap")
    results = column("\n\n".join([
        block("woocommerce/store-notices"),
        toolbar,
        product_collection(per_page=12, cols=3, inherit=True, pagination=True, align=None, filterable=True),
    ]), cls="tyche-shop__results")
    filters = column(captured("product-filters", FILTER_WORDS), width="264px", cls="tyche-shop__filters")
    body = columns(filters, results, cls="tyche-shop", align="wide", gap="60")
    return main_group(head + "\n\n" + body, pad=("40", "80"))


def product_body():
    gallery = column(captured("product-gallery"), width="58%", cls="tyche-product__gallery")
    assurances = group("\n".join(
        group(icon("tyche/" + name) + "\n" + para(text, size="small"), layout="flex", wrap="nowrap", gap="20")
        for name, text in (("truck-delivery", t("Free delivery on orders over $75")),
                           ("arrow-back-up", t("Free returns within 30 days")),
                           ("lock", t("Secure checkout")))
    ), cls="tyche-assurances", layout="flex", orientation="vertical", gap="20")
    summary = column("\n\n".join([
        block("post-terms", {"term": "product_cat", "className": "is-style-tyche-eyebrow tyche-product__category"}),
        block("post-title", {"level": 1, "className": "tyche-product__title",
                             "__woocommerceNamespace": "woocommerce/product-query/product-title"}),
        block("woocommerce/product-rating", {"isDescendentOfSingleProductTemplate": True}),
        block("woocommerce/product-price", {"isDescendentOfSingleProductTemplate": True, "fontSize": "x-large",
                                            "className": "tyche-product__price"}),
        block("post-excerpt", {"excerptLength": 60, "className": "tyche-product__excerpt",
                               "__woocommerceNamespace": "woocommerce/product-query/product-summary"}),
        block("woocommerce/add-to-cart-form", {"className": "tyche-product__add"}),
        assurances,
        block("woocommerce/product-meta", None, '<div class="wp-block-woocommerce-product-meta">\n%s\n</div>' % group(
            "\n".join([block("woocommerce/product-sku"),
                       block("post-terms", {"term": "product_tag", "prefix": "TAGS_PREFIX"})]),
            layout="flex", orientation="vertical", gap="10", cls="tyche-product__meta")),
    ]), cls="tyche-product__summary")
    top = columns(gallery, summary, cls="tyche-product", align="wide", gap="70")
    details = group(captured("product-details", ["Description", "Additional Information", "Reviews"]),
                    cls="tyche-product__details", content_size="880px")
    related = group("\n\n".join([
        section_head(t("You may also like"), level=2),
        product_collection("related", per_page=4, cols=4, related=True),
    ]), cls="tyche-product__related", align="wide", layout="default", pad=("70", "0"))
    content = main_group("\n\n".join([
        block("woocommerce/breadcrumbs", {"fontSize": "small", "align": "wide"}),
        block("woocommerce/store-notices"),
        top, details, related,
    ]), pad=("30", "80"))
    return content.replace('"TAGS_PREFIX"', '"%s"' % "<?php echo esc_attr__( 'Tags: ', 'tyche' ); ?>")


def cart_body():
    return block("woocommerce/page-content-wrapper", {"page": "cart"}, main_group("\n".join([
        block("woocommerce/store-notices"),
        block("post-title", {"level": 1, "align": "wide", "className": "tyche-page-title"}),
        block("post-content", {"align": "wide", "layout": {"type": "constrained"}}),
    ]), pad=("50", "80")))


def checkout_body():
    return block("woocommerce/page-content-wrapper", {"page": "checkout"}, main_group("\n".join([
        block("woocommerce/store-notices"),
        block("post-content", {"align": "wide", "layout": {"type": "constrained"}}),
    ]), pad=("50", "80")))


def order_confirmation_body():
    def wrapper(name, heading_slug, inner_block, align="wide"):
        return block("woocommerce/%s" % name, {"align": align}, "\n".join([
            block("pattern", {"slug": "woocommerce/%s" % heading_slug}),
            block("woocommerce/%s" % inner_block, {"lock": {"remove": True}})]))
    inner = "\n\n".join([
        block("woocommerce/order-confirmation-status", {"fontSize": "x-large", "className": "tyche-order-status"}),
        block("woocommerce/order-confirmation-summary"),
        wrapper("order-confirmation-totals-wrapper", "order-confirmation-totals-heading", "order-confirmation-totals"),
        wrapper("order-confirmation-downloads-wrapper", "order-confirmation-downloads-heading", "order-confirmation-downloads"),
        columns(
            column(wrapper("order-confirmation-shipping-wrapper", "order-confirmation-shipping-heading", "order-confirmation-shipping-address")),
            column(wrapper("order-confirmation-billing-wrapper", "order-confirmation-billing-heading", "order-confirmation-billing-address")),
            cls="wc-block-order-confirmation-address-wrapper", align="wide", gap="50"),
        block("woocommerce/order-confirmation-additional-fields-wrapper", {"align": "wide"}, "\n".join([
            block("pattern", {"slug": "woocommerce/order-confirmation-additional-fields-heading"}),
            block("woocommerce/order-confirmation-additional-fields")])),
        block("woocommerce/order-confirmation-additional-information"),
    ])
    return main_group(inner, pad=("60", "80"), cls="tyche-order-confirmation")


# ---------------------------------------------------------------------------
# Blog and pages
# ---------------------------------------------------------------------------
def post_grid(inherit=True, per_page=9, cols=3, pagination=True):
    card = "\n".join([
        block("post-featured-image", {"isLink": True, "aspectRatio": "3/2", "className": "tyche-post-card__media"}),
        block("post-terms", {"term": "category", "className": "is-style-tyche-eyebrow"}),
        block("post-title", {"level": 3, "isLink": True, "fontSize": "x-large"}),
        block("post-excerpt", {"excerptLength": 22, "className": "tyche-post-card__excerpt"}),
        block("post-date", {"fontSize": "small"}),
    ])
    template = block("post-template", {"className": "tyche-post-cards",
                                       "layout": {"type": "grid", "columnCount": cols}}, card)
    parts = [template]
    if pagination:
        parts.append(block("query-pagination", {"paginationArrow": "arrow", "layout": {"type": "flex", "justifyContent": "center"}},
                           "\n".join([block("query-pagination-previous"), block("query-pagination-numbers"),
                                      block("query-pagination-next")])))
    parts.append(block("query-no-results", None, para(t("No posts were found."))))
    query = {"perPage": per_page, "pages": 0, "offset": 0, "postType": "post", "order": "desc", "orderBy": "date",
             "author": "", "search": "", "exclude": [], "sticky": "", "inherit": inherit}
    return ("<!-- wp:query%s -->\n<div class=\"wp-block-query alignwide\">\n%s\n</div>\n<!-- /wp:query -->"
            % (attrs({"queryId": 1, "query": query, "align": "wide", "className": "tyche-posts"}), "\n\n".join(parts)))


def blog_body(kind):
    if kind == "home":
        title = heading(t("Journal"), level=1, cls="tyche-page-title")
        intro = para(t("Styling notes, new collections and the people who make them."), color="muted")
    elif kind == "search":
        title = block("query-title", {"type": "search", "level": 1, "className": "tyche-page-title"})
        intro = block("search", {"label": "SEARCH_LABEL", "showLabel": False, "buttonText": "SEARCH_LABEL",
                                 "className": "tyche-search-page__form"})
    else:
        title = block("query-title", {"type": "archive", "showPrefix": False, "level": 1, "className": "tyche-page-title"})
        intro = block("term-description")
    head = group(title + "\n" + intro, cls="tyche-page-head", align="wide", layout="flex", orientation="vertical", gap="20")
    content = main_group(head + "\n\n" + post_grid(), pad=("60", "80"))
    return content.replace('"SEARCH_LABEL"', '"%s"' % "<?php echo esc_attr__( 'Search', 'tyche' ); ?>")


def single_body():
    head = group("\n".join([
        block("post-terms", {"term": "category", "textAlign": "center", "className": "is-style-tyche-eyebrow"}),
        block("post-title", {"level": 1, "textAlign": "center", "className": "tyche-page-title"}),
        group(block("post-date", {"fontSize": "small"}) + "\n" + block("post-author-name", {"fontSize": "small"}),
              layout="flex", justify="center", gap="20", cls="tyche-post-meta"),
    ]), cls="tyche-post-head", layout="constrained")
    return main_group("\n\n".join([
        head,
        block("post-featured-image", {"aspectRatio": "16/9", "align": "wide", "className": "tyche-post-hero"}),
        block("post-content", {"layout": {"type": "constrained"}, "className": "tyche-prose"}),
        block("post-terms", {"term": "post_tag", "className": "tyche-post-tags"}),
        group(block("post-navigation-link", {"type": "previous", "showTitle": True, "arrow": "arrow"}) + "\n" +
              block("post-navigation-link", {"type": "next", "showTitle": True, "arrow": "arrow"}),
              cls="tyche-post-nav", layout="flex", justify="space-between", wrap="wrap"),
        block("comments", {"className": "tyche-comments"}, "\n".join([
            block("comments-title"),
            block("comment-template", None, "\n".join([
                block("comment-author-name"), block("comment-date"), block("comment-content"),
                block("comment-reply-link")])),
            block("comments-pagination", None, block("comments-pagination-previous") + "\n" +
                  block("comments-pagination-numbers") + "\n" + block("comments-pagination-next")),
            block("post-comments-form"),
        ])),
    ]), pad=("60", "80"))


def page_body(title=True, wide=False):
    parts = []
    if title:
        parts.append(block("post-title", {"level": 1, "align": "wide" if wide else None, "className": "tyche-page-title"}
                           if wide else {"level": 1, "className": "tyche-page-title"}))
    parts.append(block("post-content", {"align": "wide" if wide else "full", "layout": {"type": "constrained"}}))
    if not title:
        return group(parts[0], tag="main", cls="tyche-main tyche-main--flush", margin_top="0")
    return main_group("\n\n".join(parts), pad=("60", "80"))


def not_found_body():
    head = group("\n".join([
        eyebrow(t("Error 404"), align="center"),
        heading(t("This page has moved on"), level=1, align="center", cls="tyche-page-title"),
        para(t("The link may be old, or the product may have sold out. Try a search, or start again from the shop."),
             align="center", color="muted"),
        block("search", {"label": "SEARCH_LABEL", "showLabel": False, "placeholder": "SEARCH_PLACEHOLDER",
                         "buttonText": "SEARCH_LABEL", "query": {"post_type": "product"}, "className": "tyche-404__search"}),
        buttons(button(t("Back to the shop"), url("shop")), justify="center"),
    ]), cls="tyche-404", layout="constrained", content_size="620px")
    write_pattern("hidden-404-products", "404 product suggestions", IF_WOO + "\n" + group(
        section_head(t("Popular right now")) + "\n\n" + product_collection("best-sellers", per_page=4, cols=4),
        align="wide", layout="default", pad=("80", "0")) + "\n" + END_IF, inserter=False)
    content = main_group(head + "\n\n" + pattern_ref("hidden-404-products"), pad=("80", "80"))
    content = content.replace('"SEARCH_LABEL"', '"%s"' % "<?php echo esc_attr__( 'Search', 'tyche' ); ?>")
    return content.replace('"SEARCH_PLACEHOLDER"', '"%s"' % "<?php echo esc_attr__( 'Search products', 'tyche' ); ?>")


# ---------------------------------------------------------------------------
# Homepage sections
# ---------------------------------------------------------------------------
def hero():
    inner = "\n".join([
        eyebrow(t("New season"), color="overlay"),
        heading(t("The autumn edit"), level=1, size="colossal", color="overlay", cls="tyche-hero__title"),
        para(t("Wool coats, soft knitwear and the pieces you will reach for all season long."),
             size="large", color="overlay", cls="tyche-hero__lede"),
        buttons(button(t("Shop new arrivals"), url("shop"), bg="overlay", color="contrast"),
                button(t("Explore the lookbook"), "#", style="tyche-outline", color="overlay")),
    ])
    return cover(group(inner, layout="default", cls="tyche-hero__content"),
                 "hero-1", min_height=86, unit="vh", position="bottom left", cls="tyche-hero",
                 align="full", gradient=SCRIM_SIDE)


def category_tiles():
    tiles = []
    for slug, name, note in (("cat-coats", "Coats", "Wool, cashmere and waxed cotton"),
                             ("cat-knitwear", "Knitwear", "Soft layers for cold mornings"),
                             ("cat-dresses", "Dresses", "Easy shapes, day to evening"),
                             ("cat-accessories", "Accessories", "Scarves, bags and finishing touches")):
        inner = "\n".join([
            heading('<a href="%s">%s</a>' % (url("shop"), t(name)), level=3, color="overlay", size="xx-large",
                    cls="tyche-tile__title"),
            para(t(note), color="overlay", size="small"),
        ])
        tiles.append(column(cover(inner, slug, position="bottom left", ratio="4/5",
                                  cls="tyche-tile is-style-tyche-zoom", gradient=SCRIM)))
    body = section_head(t("Shop by category"), kicker=t("Collections"), link_text=t("View all"),
                        link_href=url("shop")) + "\n\n" + columns(*tiles, cls="tyche-tiles", align="wide", gap="40")
    return section(body, cls="tyche-categories")


def product_row(collection, kicker, title, link, carousel=False, bg=None):
    body = section_head(t(title), kicker=t(kicker), link_text=t(link), link_href=url("shop"))
    body += "\n\n" + product_collection(collection, per_page=8 if carousel else 4, cols=4, carousel=carousel)
    return IF_WOO + "\n" + section(body, cls="tyche-product-row", bg=bg) + "\n" + END_IF


def story_split():
    text = "\n".join([
        eyebrow(t("Our craft")),
        heading(t("Made to be worn for years, not seasons"), level=2, size="huge"),
        para(t("Every piece starts with a fabric we can trace and a maker we have met. We cut in small runs, finish by hand and "
               "repair what we sell, so the coat you buy this autumn is still the one you wear in ten years."),
             size="large", color="muted"),
        check_list(t("Traceable wool from family-run farms"), t("Finished by hand in small batches"),
                   t("Free repairs for the first year")),
        buttons(button(t("Read our story"), "#", style="tyche-outline")),
    ])
    body = columns(column(image("story-1", ta("A tailor pressing the seam of a wool coat"), ratio="4/5",
                                cls="tyche-story__image"), width="50%"),
                   column(group(text, layout="flex", orientation="vertical", gap="40"), valign="center"),
                   cls="tyche-story", align="wide", gap="80", valign="center")
    return section(body, bg="surface")


def promo_duo():
    def promo(slug, kicker, title, text, cta):
        return column(cover("\n".join([
            eyebrow(t(kicker), color="overlay"),
            heading(t(title), level=2, color="overlay", size="huge"),
            para(t(text), color="overlay"),
            buttons(button(t(cta), url("shop"), bg="overlay", color="contrast")),
        ]), slug, min_height=560, position="bottom left", cls="tyche-promo is-style-tyche-zoom", gradient=SCRIM))
    body = columns(
        promo("promo-1", "Sale", "Up to 40% off outerwear", "Last season's coats and jackets, while sizes last.",
              "Shop the sale"),
        promo("promo-2", "Just landed", "The cashmere capsule", "Six pieces, three colours and one very soft fabric.",
              "Discover the capsule"),
        cls="tyche-promos", align="wide", gap="40")
    return section(body, pad=("0", "70"))


def usp_strip():
    items = []
    for name, title, text in (("truck-delivery", "Free delivery over $75", "Tracked delivery in two to four working days."),
                              ("arrow-back-up", "30-day returns", "Changed your mind? Send it back for free."),
                              ("lock", "Secure payment", "Card, wallet and pay-later options at checkout."),
                              ("headset", "Real people", "Our team answers every message within a day.")):
        items.append(column(group("\n".join([
            icon("tyche/" + name, cls="tyche-icon tyche-icon--large"),
            heading(t(title), level=3, cls="tyche-usp__title", size="medium", family="figtree"),
            para(t(text), size="small", color="muted"),
        ]), layout="flex", orientation="vertical", gap="20", cls="tyche-usp")))
    return section(columns(*items, cls="tyche-usps", align="wide", gap="50"), pad="60", cls="tyche-usp-band")


def reviews():
    cards = []
    for quote, name, bought, avatar in (
            ("The overcoat is heavier and better made than anything I have bought in years. It arrived in two days, beautifully packed.",
             "Hannah M.", "Wool overcoat", "avatar-1"),
            ("I sent back one size and had the swap within the week, with no questions asked. That is why I keep coming back.",
             "Daniel R.", "Merino cardigan", "avatar-2"),
            ("Soft, warm and it still looks new after a winter of wearing it almost every day. Worth every penny.",
             "Priya S.", "Cashmere scarf", "avatar-3")):
        cards.append(column(group("\n".join([
            para("&#9733;&#9733;&#9733;&#9733;&#9733;", cls="tyche-stars"),
            para(t(quote), size="large", cls="tyche-review__quote"),
            group(image(avatar, "", ratio="1", cls="tyche-review__avatar") + "\n" +
                  group(para("<strong>%s</strong>" % name, size="small") + "\n" +
                        para(t("Verified buyer") + " &middot; " + t(bought), size="small", color="muted"),
                        layout="flex", orientation="vertical", gap="10"),
                  layout="flex", wrap="nowrap", gap="30", cls="tyche-review__author"),
        ]), cls="is-style-tyche-card tyche-review", layout="flex", orientation="vertical", gap="40")))
    head = group("\n".join([
        eyebrow(t("Reviews"), align="center"),
        heading(t("Loved by people who wear it every day"), level=2, align="center"),
    ]), layout="constrained", content_size="640px", gap="20")
    return section(head + "\n\n" + columns(*cards, cls="tyche-reviews", align="wide", gap="40"), bg="surface")


def journal():
    body = section_head(t("From the journal"), kicker=t("Stories"), link_text=t("All stories"), link_href="#")
    body += "\n\n" + post_grid(inherit=False, per_page=3, cols=3, pagination=False)
    return section(body)


def newsletter():
    left = column("\n".join([
        heading(t("Take 10% off your first order"), level=2, size="huge", color="overlay"),
        para(t("Create an account for early access to new collections, members-only offers and faster checkout."),
             color="on-dark", size="large"),
    ]), width="60%")
    right = column(buttons(button(t("Create an account"), url("myaccount"), bg="overlay", color="contrast")),
                   valign="center", cls="tyche-newsletter__action")
    return section(columns(left, right, align="wide", gap="60", valign="center", cls="tyche-newsletter"),
                   bg="dark", color="on-dark", pad="70")


HOME_SECTIONS = [
    ("hero", "Hero: full-width photograph", hero, STORE, ["hero", "banner", "cover"]),
    ("categories", "Shop by category tiles", category_tiles, STORE, ["category", "collection", "tiles"]),
    ("products-new", "Product row: new arrivals", lambda: product_row("new-arrivals", "Just in", "New arrivals", "Shop all new"), STORE, ["products", "new"]),
    ("story", "Brand story with photograph", story_split, CONTENT, ["about", "story", "craft"]),
    ("products-best", "Product carousel: best sellers", lambda: product_row("best-sellers", "Most loved", "Best sellers", "Shop best sellers", carousel=True), STORE, ["products", "carousel", "best sellers"]),
    ("promos", "Two promotions", promo_duo, STORE, ["sale", "promotion", "banner"]),
    ("usps", "Store promises with icons", usp_strip, STORE, ["delivery", "returns", "features"]),
    ("reviews", "Customer reviews", reviews, CONTENT, ["testimonials", "reviews"]),
    ("journal", "Latest journal posts", journal, CONTENT, ["blog", "posts", "news"]),
    ("newsletter", "Account sign-up call to action", newsletter, STORE, ["newsletter", "signup", "cta"]),
]


# ---------------------------------------------------------------------------
# Build
# ---------------------------------------------------------------------------
def main():
    header_pattern()
    footer_pattern()
    checkout_header_pattern()

    for slug, title, fn, cats, keywords in HOME_SECTIONS:
        write_pattern(slug, title, fn(), categories=cats, keywords=keywords)
    write_pattern("page-home", "Store homepage", "\n\n".join(pattern_ref(s[0]) for s in HOME_SECTIONS),
                  categories=PAGES, keywords=["home", "front page"], template_types=["front-page"],
                  block_types=["core/post-content"], post_types=["page"],
                  description="The designed store homepage. Offered when you create a page.")

    hidden = {
        "hidden-shop": shop_body(),
        "hidden-shop-search": shop_body(search=True),
        "hidden-product": product_body(),
        "hidden-cart": cart_body(),
        "hidden-checkout": checkout_body(),
        "hidden-order-confirmation": order_confirmation_body(),
        "hidden-blog": blog_body("home"),
        "hidden-archive": blog_body("archive"),
        "hidden-search": blog_body("search"),
        "hidden-single": single_body(),
        "hidden-page": page_body(),
        "hidden-page-no-title": page_body(title=False),
        "hidden-page-wide": page_body(wide=True),
        "hidden-404": not_found_body(),
    }
    for slug, content in hidden.items():
        write_pattern(slug, slug.replace("hidden-", "").replace("-", " ").capitalize() + " template body",
                      content, inserter=False)

    write_file("parts/header.html", pattern_ref("header"))
    write_file("parts/footer.html", pattern_ref("footer"))
    write_file("parts/checkout-header.html", pattern_ref("checkout-header"))

    templates = {
        "index": "hidden-blog", "home": "hidden-blog", "archive": "hidden-archive", "search": "hidden-search",
        "single": "hidden-single", "page": "hidden-page", "page-no-title": "hidden-page-no-title",
        "page-wide": "hidden-page-wide", "404": "hidden-404",
        "archive-product": "hidden-shop", "taxonomy-product_cat": "hidden-shop",
        "taxonomy-product_tag": "hidden-shop", "taxonomy-product_attribute": "hidden-shop",
        "product-search-results": "hidden-shop-search", "single-product": "hidden-product",
        "page-cart": "hidden-cart", "order-confirmation": "hidden-order-confirmation",
    }
    for name, body in templates.items():
        write_file("templates/%s.html" % name, page_template(body))
    write_file("templates/page-checkout.html", page_template("hidden-checkout", header="checkout-header", footer=None))
    write_file("templates/front-page.html", page_template("page-home"))

    print("%d files written" % len(WRITTEN))


if __name__ == "__main__":
    main()
