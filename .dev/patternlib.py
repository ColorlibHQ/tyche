#!/usr/bin/env python3
"""Block markup helpers for Tyche's pattern generators.

Block comment attributes have to match exactly what a block's save() function
writes, or the editor shows "this block contains unexpected or invalid content"
and offers to recover it. Nothing warns you at build time and the front end
looks fine, so hand-written block markup is a standing trap. These helpers emit
the shapes that have been validated through the parser, and every generated
pattern goes through .dev/validate-blocks.mjs before it ships.

Conventions enforced here:

- A section is a full-width constrained group with **top and bottom padding
  only**. `useRootPaddingAwareAlignments` is on, so an alignfull constrained
  group already takes its left/right padding from the root; adding L/R padding
  double-pads it.
- Colours are palette slugs, never literals, so all eight colour variations
  restyle every pattern.
- Spacing comes from sp(), which refuses anything off the registered scale --
  an undefined preset variable makes WordPress drop the declaration and the
  element falls back to its inherited gap, silently.
"""

import collections
import json

SPACING = {"10", "20", "30", "40", "50", "60", "70", "80"}


def sp(slug):
    slug = str(slug)
    if slug not in SPACING:
        raise ValueError("spacing %r is off the scale %s" % (slug, sorted(SPACING)))
    return "var:preset|spacing|" + slug


def spc(slug):
    """The CSS form of the same value, for inline style attributes."""
    slug = str(slug)
    if slug not in SPACING:
        raise ValueError("spacing %r is off the scale" % slug)
    return "var(--wp--preset--spacing--%s)" % slug


def attrs(data):
    """Block comment attributes: compact JSON, exactly as the editor writes it."""
    if not data:
        return ""
    return " " + json.dumps(data, separators=(",", ":"), ensure_ascii=False)


def classes(*names):
    return " ".join(n for n in names if n)


def esc(text):
    """Pass authored markup through unchanged.

    Every string in the generators is written by hand in this repository and
    already contains the entities it wants -- `&amp;`, `&mdash;`, `&ldquo;`.
    Escaping here turned `&amp;` into `&amp;amp;` and rendered "Lunch &amp;
    dinner" on the page. paragraph() has always passed its text through for the
    same reason; heading() and button() now agree with it.

    Nothing here takes user input. Anything that ever does must be escaped by
    its caller before it arrives.
    """
    return text


# ---------------------------------------------------------------------------
# Leaf blocks
# ---------------------------------------------------------------------------
def heading(text, level=2, align=None, color=None, size=None, style=None,
            extra_class=None, margin_bottom=None, transform=None, tag=None):
    data = {}
    css = []
    cls = ["wp-block-heading"]

    if level != 2:
        data["level"] = level
    if align:
        data["textAlign"] = align
        cls.append("has-text-align-" + align)
    if color:
        data["textColor"] = color
        cls += ["has-" + color + "-color", "has-text-color"]
    if size:
        data["fontSize"] = size
        cls.append("has-" + size + "-font-size")
    if style:
        data["className"] = "is-style-" + style
        cls.append("is-style-" + style)
    if extra_class:
        data["className"] = (data.get("className", "") + " " + extra_class).strip()
        cls.append(extra_class)
    if margin_bottom:
        data.setdefault("style", {}).setdefault("spacing", {}).setdefault("margin", {})["bottom"] = sp(margin_bottom)
        css.append("margin-bottom:" + spc(margin_bottom))
    if transform:
        data.setdefault("style", {}).setdefault("typography", {})["textTransform"] = transform
        css.append("text-transform:" + transform)

    name = tag or ("h%d" % level)
    style_attr = ' style="%s"' % ";".join(css) if css else ""
    return '<!-- wp:heading%s -->\n<%s class="%s"%s>%s</%s>\n<!-- /wp:heading -->' % (
        attrs(data), name, classes(*cls), style_attr, esc(text), name
    )


def paragraph(text, align=None, color=None, size=None, style=None,
              extra_class=None, margin_bottom=None, max_width=None, placeholder=None):
    data = {}
    if placeholder is not None:
        # Shown by the editor while the paragraph has no text; not saved into the HTML.
        data["placeholder"] = placeholder
    css = []
    cls = []

    if align:
        data["align"] = align
        cls.append("has-text-align-" + align)
    if color:
        data["textColor"] = color
        cls += ["has-" + color + "-color", "has-text-color"]
    if size:
        data["fontSize"] = size
        cls.append("has-" + size + "-font-size")
    if style:
        data["className"] = "is-style-" + style
        cls.append("is-style-" + style)
    if extra_class:
        data["className"] = (data.get("className", "") + " " + extra_class).strip()
        cls.append(extra_class)
    if margin_bottom:
        data.setdefault("style", {}).setdefault("spacing", {}).setdefault("margin", {})["bottom"] = sp(margin_bottom)
        css.append("margin-bottom:" + spc(margin_bottom))
    if max_width:
        data.setdefault("style", {})["layout"] = {"selfStretch": "fixed", "flexSize": max_width}

    class_attr = ' class="%s"' % classes(*cls) if cls else ""
    style_attr = ' style="%s"' % ";".join(css) if css else ""
    return '<!-- wp:paragraph%s -->\n<p%s%s>%s</p>\n<!-- /wp:paragraph -->' % (
        attrs(data), class_attr, style_attr, text
    )


def button(text, url="#", style=None, width=None, extra_class=None, background=None, text_color=None):
    """A core/button.

    `background` and `text_color` are palette slugs. A button on the page ground
    needs neither — theme.json styles it `primary` with an `on-primary` label —
    but a button sitting on a `primary` ground inherits a fill identical to what
    is behind it and vanishes. The call-to-action band did exactly that. Name
    the colours for any button that is not on the page ground.

    The colour parameter is `text_color`, not `text`: `text` is already the
    label, and reusing the name would silently put the label into the colour.
    """
    data = {}
    cls = ["wp-block-button"]
    link = ["wp-block-button__link"]
    if style:
        data["className"] = "is-style-" + style
        cls.append("is-style-" + style)
    if extra_class:
        # Has to reach the block's className attribute, not just the markup:
        # render_block_core/button reads the attribute, and a class that exists
        # only in the HTML is invisible to it.
        data["className"] = (data.get("className", "") + " " + extra_class).strip()
        cls.append(extra_class)
    if width:
        data["width"] = width
        cls.append("has-custom-width wp-block-button__width-%d" % width)
    if background:
        data["backgroundColor"] = background
    if text_color:
        data["textColor"] = text_color
    # Core's save() order. normalize-blocks.mjs re-serialises anyway, but
    # writing it right the first time keeps that pass a no-op.
    if text_color:
        link.append("has-%s-color" % text_color)
    if background:
        link.append("has-%s-background-color" % background)
    if text_color:
        link.append("has-text-color")
    if background:
        link.append("has-background")
    link.append("wp-element-button")
    return (
        '<!-- wp:button%s -->\n'
        '<div class="%s"><a class="%s" href="%s">%s</a></div>\n'
        '<!-- /wp:button -->' % (attrs(data), classes(*cls), classes(*link), url, esc(text))
    )


def buttons(items, align=None, gap=None, nowrap=False):
    """A core/buttons wrapper.

    The wrapper carries `class="wp-block-buttons"` and nothing else. Layout
    classes (`is-layout-flex`, `is-content-justification-center`) and the gap
    are both generated by WordPress from the layout and style attributes at
    render time -- writing them into the saved markup is what made every
    buttons block in the theme parse as invalid.
    """
    data = {}
    if align:
        data["layout"] = {"type": "flex", "justifyContent": align}
    if nowrap:
        data.setdefault("layout", {"type": "flex"})["flexWrap"] = "nowrap"
    if gap:
        data.setdefault("style", {}).setdefault("spacing", {})["blockGap"] = sp(gap)

    inner = "\n".join(items)
    return '<!-- wp:buttons%s -->\n<div class="wp-block-buttons">%s</div>\n<!-- /wp:buttons -->' % (
        attrs(data), "\n" + inner + "\n"
    )


def image(slug, alt, ratio=None, scale="cover", style=None, rounded=None, lightbox=False, width=None):
    """A core/image, in the exact shape core's save() writes.

    Two details that are easy to get wrong and that make the editor declare the
    block invalid: a border radius adds `has-custom-border` to the FIGURE as
    well as the radius to the img, and the radius comes FIRST in the img's
    style, before aspect-ratio. Both were verified by serialising a real
    core/image in the browser (.dev/normalize-blocks.mjs does that routinely).

    `lightbox` switches on core's own enlarge-on-click, which needs no script of
    the theme's and which an editor can turn off per image. `width` fixes a small
    image such as an avatar.
    """
    data = {}
    cls = ["wp-block-image", "size-large"]
    declarations = []

    if lightbox:
        data["lightbox"] = {"enabled": True}
    if ratio:
        data["aspectRatio"] = ratio
        data["scale"] = scale
    if width:
        data["width"] = width
        cls.append("is-resized")
    data["sizeSlug"] = "large"
    data["linkDestination"] = "none"

    if rounded:
        data.setdefault("style", {}).setdefault("border", {})["radius"] = rounded
        cls.append("has-custom-border")
        declarations.append("border-radius:" + rounded)

    if ratio:
        declarations += ["aspect-ratio:" + ratio, "object-fit:" + scale]
    if width:
        declarations.append("width:" + width)

    if style:
        data["className"] = "is-style-" + style
        cls.insert(2, "is-style-" + style)

    img_style = ' style="%s"' % ";".join(declarations) if declarations else ""
    url = "<?php echo esc_url( get_theme_file_uri( 'assets/images/%s.jpg' ) ); ?>" % slug
    return (
        '<!-- wp:image%s -->\n'
        '<figure class="%s"><img src="%s" alt="%s"%s/></figure>\n'
        '<!-- /wp:image -->' % (attrs(data), classes(*cls), url, alt, img_style)
    )


def spacer(height="40"):
    return ('<!-- wp:spacer {"height":"%s"} -->\n'
            '<div style="height:%s" aria-hidden="true" class="wp-block-spacer"></div>\n'
            '<!-- /wp:spacer -->' % (spc(height), spc(height)))


def separator(style=None, align=None):
    data = {"className": "is-style-" + style}
    cls = ["wp-block-separator", "has-alpha-channel-opacity", "is-style-" + style]
    if align:
        data["align"] = align
        cls.append("align" + align)
    return '<!-- wp:separator%s -->\n<hr class="%s"/>\n<!-- /wp:separator -->' % (
        attrs(data), classes(*cls)
    )


def shortcode(text):
    return '<!-- wp:shortcode -->\n%s\n<!-- /wp:shortcode -->' % text


# ---------------------------------------------------------------------------
# Containers
# ---------------------------------------------------------------------------
def group(inner, align=None, background=None, text=None, padding_y=None,
          gap=None, layout="constrained", content_size=None, extra_class=None,
          style=None, tag="div", justify=None, orientation=None, wrap=None,
          padding=None, radius=None, anchor=None):
    """A group. Sections use align='full' with top/bottom padding only.

    `anchor` becomes the element's id, which is how an in-page link reaches a
    section. Anchors must be unique per page: two sections sharing one id is
    invalid HTML and the browser only ever scrolls to the first.
    """
    data = {}
    if anchor:
        data["anchor"] = anchor
    css = []
    cls = ["wp-block-group"]

    if align:
        data["align"] = align
        cls.append("align" + align)
    if background:
        data["backgroundColor"] = background
        cls += ["has-" + background + "-background-color", "has-background"]
    if text:
        data["textColor"] = text
        cls += ["has-" + text + "-color", "has-text-color"]
    if style:
        data["className"] = "is-style-" + style
        cls.append("is-style-" + style)
    if extra_class:
        data["className"] = (data.get("className", "") + " " + extra_class).strip()
        cls.append(extra_class)

    spacing = {}
    if padding_y:
        # Top and bottom only: root padding already supplies left and right for
        # an alignfull constrained group, and setting them here double-pads.
        spacing["padding"] = {"top": sp(padding_y), "bottom": sp(padding_y)}
        css += ["padding-top:" + spc(padding_y), "padding-bottom:" + spc(padding_y)]
    if padding:
        spacing["padding"] = {k: sp(v) for k, v in padding.items()}
        css += ["padding-%s:%s" % (k, spc(v)) for k, v in padding.items()]
    if gap:
        spacing["blockGap"] = sp(gap)
    if spacing:
        data.setdefault("style", {})["spacing"] = spacing
    if radius:
        data.setdefault("style", {}).setdefault("border", {})["radius"] = radius
        css.append("border-radius:" + radius)

    layout_data = {"type": layout}
    if content_size:
        layout_data["contentSize"] = content_size
    if justify:
        layout_data["justifyContent"] = justify
    if orientation:
        layout_data["orientation"] = orientation
    if wrap:
        layout_data["flexWrap"] = wrap
    data["layout"] = layout_data

    if tag != "div":
        data["tagName"] = tag

    if layout == "flex":
        cls.append("is-layout-flex")
        if justify:
            cls.append("is-content-justification-" + justify)

    style_attr = ' style="%s"' % ";".join(css) if css else ""
    id_attr = ' id="%s"' % anchor if anchor else ""
    return '<!-- wp:group%s -->\n<%s%s class="%s"%s>\n%s\n</%s>\n<!-- /wp:group -->' % (
        attrs(data), tag, id_attr, classes(*cls), style_attr, inner, tag
    )


def columns(cols, align=None, gap=None, vertical=None, stack_on_mobile=True,
            extra_class=None):
    data = {}
    css = []
    cls = ["wp-block-columns"]

    if align:
        data["align"] = align
        cls.append("align" + align)
    if not stack_on_mobile:
        data["isStackedOnMobile"] = False
        cls.append("is-not-stacked-on-mobile")
    if vertical:
        data["verticalAlignment"] = vertical
        cls.append("are-vertically-aligned-" + vertical)
    if gap:
        data.setdefault("style", {}).setdefault("spacing", {})["blockGap"] = {
            "top": sp(gap), "left": sp(gap)
        }
    if extra_class:
        data["className"] = extra_class
        cls.append(extra_class)

    style_attr = ' style="%s"' % ";".join(css) if css else ""
    inner = "\n".join(cols)
    return '<!-- wp:columns%s -->\n<div class="%s"%s>\n%s\n</div>\n<!-- /wp:columns -->' % (
        attrs(data), classes(*cls), style_attr, inner
    )


def column(inner, width=None, vertical=None, background=None, padding=None,
           extra_class=None, style=None):
    data = {}
    css = []
    cls = ["wp-block-column"]

    if width:
        data["width"] = width
        css.append("flex-basis:" + width)
    if vertical:
        data["verticalAlignment"] = vertical
        cls.append("is-vertically-aligned-" + vertical)
    if background:
        data["backgroundColor"] = background
        cls += ["has-" + background + "-background-color", "has-background"]
    if style:
        data["className"] = "is-style-" + style
        cls.append("is-style-" + style)
    if extra_class:
        data["className"] = (data.get("className", "") + " " + extra_class).strip()
        cls.append(extra_class)
    if padding:
        data.setdefault("style", {}).setdefault("spacing", {})["padding"] = {
            k: sp(v) for k, v in padding.items()
        }
        css += ["padding-%s:%s" % (k, spc(v)) for k, v in padding.items()]

    style_attr = ' style="%s"' % ";".join(css) if css else ""
    return '<!-- wp:column%s -->\n<div class="%s"%s>\n%s\n</div>\n<!-- /wp:column -->' % (
        attrs(data), classes(*cls), style_attr, inner
    )


def cover(inner, slug, overlay="dark", dim=60, min_height=None, align="full",
          extra_class=None, gradient=None, content_position=None, min_height_unit=None):
    """A core/cover over one of the theme's photographs.

    The order of the two children matters: core writes the background <img>
    BEFORE the dim <span>. Writing the span first -- which reads more naturally
    and is what the first version of this did -- makes every cover in the theme
    parse as invalid, which is eleven patterns here. Attribute order in the
    comment matters too, and follows core's own: url, dimRatio, overlayColor,
    isUserOverlayColor, minHeight, align, className, layout.
    """
    data = collections.OrderedDict()
    data["url"] = "TYCHE_IMAGE"
    data["dimRatio"] = dim
    if gradient:
        data["customGradient"] = gradient
    else:
        data["overlayColor"] = overlay
        data["isUserOverlayColor"] = True
    if min_height:
        data["minHeight"] = min_height
        if min_height_unit:
            data["minHeightUnit"] = min_height_unit
    if content_position:
        data["contentPosition"] = content_position
    if align:
        data["align"] = align
    if extra_class:
        data["className"] = extra_class
    data["layout"] = {"type": "constrained"}

    cls = ["wp-block-cover"]
    if align:
        cls.append("align" + align)
    if content_position:
        cls.append("has-custom-content-position")
        cls.append("is-position-" + content_position.replace(" ", "-"))
    if extra_class:
        cls.append(extra_class)

    unit = min_height_unit or "px"
    css = ["min-height:%d%s" % (min_height, unit)] if min_height else []
    style_attr = ' style="%s"' % ";".join(css) if css else ""

    if gradient:
        span = ('<span aria-hidden="true" class="wp-block-cover__background '
                'has-background-gradient" style="background:%s"></span>' % gradient)
    else:
        # Core's dimRatioToClass() rounds to the nearest ten -- the attribute
        # keeps the exact value but the class does not, because the stylesheet
        # only defines steps of ten. Writing `has-background-dim-62` for
        # dimRatio 62 makes the block invalid; it has to be `-60`.
        span = ('<span aria-hidden="true" class="wp-block-cover__background '
                'has-%s-background-color has-background-dim-%d has-background-dim"></span>'
                % (overlay, 10 * round(dim / 10)))

    url = "<?php echo esc_url( get_theme_file_uri( 'assets/images/%s.jpg' ) ); ?>" % slug
    attr_json = attrs(data).replace('"TYCHE_IMAGE"', '"%s"' % url)

    return (
        '<!-- wp:cover%s -->\n'
        '<div class="%s"%s>'
        '<img class="wp-block-cover__image-background" alt="" src="%s" data-object-fit="cover"/>'
        '%s'
        '<div class="wp-block-cover__inner-container">\n%s\n</div></div>\n'
        '<!-- /wp:cover -->' % (attr_json, classes(*cls), style_attr, url, span, inner)
    )
