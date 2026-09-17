#!/usr/bin/env python3
"""
Generates theme.json and every style variation from one table of colours.

A store puts more colour pairs side by side than a brochure site does: sale
prices, badges on product photographs, notices, the dark announcement bar and
footer, filled and outlined buttons. Every pair the design produces is listed in
CONTRAST_CHECKS, and audit() refuses to write a palette where any of them fails
WCAG AA. Nothing here is eyeballed.

Usage:  python3 .dev/build_theme.py
"""

import collections
import json
import os

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
os.chdir(ROOT)

# ---------------------------------------------------------------------------
# Palette
# ---------------------------------------------------------------------------
# The same slugs in every variation, so a pattern written against them works
# under all of them. Slugs name a JOB, not a hue:
#   overlay     text on a dimmed photograph; near-white in every palette, dark
#               ones included, because a cover's dim is always dark.
#   on-dark     body text on the `dark` ground (announcement bar, footer).
#   on-primary  button labels. Measured per palette, never assumed.
#   sale        sale prices and the sale badge fill; readable as text on base.
# Never name a slug after a core utility class (`text`, `border`, `background`,
# `link`): core emits `has-border-color` on its own, and a palette slug called
# `border` made that class set the text colour too.
PALETTE = [
    ("Base",         "base"),
    ("Surface",      "surface"),
    ("Contrast",     "contrast"),
    ("Muted",        "muted"),
    ("Primary",      "primary"),
    ("Primary deep", "primary-deep"),
    ("On primary",   "on-primary"),
    ("Accent",       "accent"),
    ("Sale",         "sale"),
    ("On sale",      "on-sale"),
    ("Success",      "success"),
    ("Dark",         "dark"),
    ("On dark",      "on-dark"),
    ("Divider",      "divider"),
    ("Overlay",      "overlay"),
]

COLOR_SETS = collections.OrderedDict([
    # Default. Warm paper, espresso ink, a terracotta sale colour.
    ("colors-1-linen", ("Linen", {
        "base": "#fbf9f6", "surface": "#f2ede6", "contrast": "#1f1b17", "muted": "#675e55",
        "primary": "#1f1b17", "primary-deep": "#4a4139", "on-primary": "#fbf9f6",
        "accent": "#b86b4b", "sale": "#a3402a", "on-sale": "#ffffff", "success": "#2f6b43",
        "dark": "#1f1b17", "on-dark": "#d8cfc4", "divider": "#e3dbd0", "overlay": "#ffffff",
    })),
    # Stark black and white, for luxury and streetwear.
    ("colors-2-noir", ("Noir", {
        "base": "#ffffff", "surface": "#f4f4f4", "contrast": "#0a0a0a", "muted": "#5c5c5c",
        "primary": "#0a0a0a", "primary-deep": "#3d3d3d", "on-primary": "#ffffff",
        "accent": "#8a8a8a", "sale": "#b3261e", "on-sale": "#ffffff", "success": "#1f7a4a",
        "dark": "#0a0a0a", "on-dark": "#c9c9c9", "divider": "#e4e4e4", "overlay": "#ffffff",
    })),
    # Home and living. Muted sage with a deep olive button.
    ("colors-3-sage", ("Sage", {
        "base": "#f8f8f3", "surface": "#eceee3", "contrast": "#1d231c", "muted": "#5a6356",
        "primary": "#3e5a3a", "primary-deep": "#2c4229", "on-primary": "#ffffff",
        "accent": "#8fa58a", "sale": "#9c3f26", "on-sale": "#ffffff", "success": "#3e5a3a",
        "dark": "#1d231c", "on-dark": "#cfd6c8", "divider": "#dde1d3", "overlay": "#ffffff",
    })),
    # Beauty and wellness. Blush ground, plum ink.
    ("colors-4-blush", ("Blush", {
        "base": "#fdf8f6", "surface": "#f7e9e4", "contrast": "#2d1a22", "muted": "#6e5660",
        "primary": "#6b2a45", "primary-deep": "#511d33", "on-primary": "#ffffff",
        "accent": "#d9a3a8", "sale": "#a82c3c", "on-sale": "#ffffff", "success": "#2f6b43",
        "dark": "#2d1a22", "on-dark": "#e3cfd6", "divider": "#eedcd5", "overlay": "#ffffff",
    })),
    # Electronics and gadgets. Cool paper, cobalt.
    ("colors-5-cobalt", ("Cobalt", {
        "base": "#ffffff", "surface": "#f1f4f9", "contrast": "#0e1726", "muted": "#526075",
        "primary": "#1f4fd8", "primary-deep": "#173da8", "on-primary": "#ffffff",
        "accent": "#7aa2ff", "sale": "#c0262d", "on-sale": "#ffffff", "success": "#157347",
        "dark": "#0e1726", "on-dark": "#c5cfdf", "divider": "#dde3ec", "overlay": "#ffffff",
    })),
    # Food and grocery. Fresh green with a warm orange accent.
    ("colors-6-market", ("Market", {
        "base": "#fffdf8", "surface": "#f5f1e6", "contrast": "#1c2419", "muted": "#58604f",
        "primary": "#2e6b30", "primary-deep": "#225124", "on-primary": "#ffffff",
        "accent": "#f29a38", "sale": "#b3431c", "on-sale": "#ffffff", "success": "#2e6b30",
        "dark": "#1c2419", "on-dark": "#d3dac9", "divider": "#e6e0cf", "overlay": "#ffffff",
    })),
    # Dark palettes: `base` is the page, so it is dark. A button is a light fill,
    # which makes its label the DARK colour — the reason labels are measured.
    ("colors-7-midnight", ("Midnight", {
        "base": "#101114", "surface": "#1a1c21", "contrast": "#f2f1ee", "muted": "#a7a49e",
        "primary": "#f2f1ee", "primary-deep": "#cfccc5", "on-primary": "#101114",
        "accent": "#c9a26b", "sale": "#ff8a70", "on-sale": "#101114", "success": "#6fcf8f",
        "dark": "#08090b", "on-dark": "#a7a49e", "divider": "#2a2d33", "overlay": "#ffffff",
    })),
    ("colors-8-espresso", ("Espresso", {
        "base": "#1b1512", "surface": "#261e1a", "contrast": "#f3ebe3", "muted": "#b3a597",
        "primary": "#e8c9a6", "primary-deep": "#f3dcc2", "on-primary": "#1b1512",
        "accent": "#b86b4b", "sale": "#ff9b7a", "on-sale": "#1b1512", "success": "#86d19c",
        "dark": "#120e0c", "on-dark": "#b3a597", "divider": "#352b25", "overlay": "#ffffff",
    })),
])

# Every foreground/background pair the design puts together.
CONTRAST_CHECKS = [
    ("contrast", "base"), ("contrast", "surface"),
    ("muted", "base"), ("muted", "surface"),
    ("primary", "base"), ("primary", "surface"),      # links and outline buttons
    ("primary-deep", "base"),                         # hovered links
    ("on-primary", "primary"), ("on-primary", "primary-deep"),
    ("sale", "base"), ("sale", "surface"),            # sale prices
    ("on-sale", "sale"),                              # sale badge label
    ("success", "base"),                              # "In stock"
    ("on-dark", "dark"), ("overlay", "dark"),         # announcement bar, footer
    # Light buttons on photographs: an `overlay` fill with a `dark` label. The
    # label was `contrast` until the dark palettes turned it near-white on white.
    ("dark", "overlay"),
]

# ---------------------------------------------------------------------------
# Typography
# ---------------------------------------------------------------------------
# Each face ships as two files split by unicode-range: `latin` for English and
# `latin-ext` for most European shop languages. A browser only downloads the
# second file when a page contains a character from its range.
LATIN = ("U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, "
         "U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD")
LATIN_EXT = ("U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, "
             "U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, "
             "U+2113, U+2C60-2C7F, U+A720-A7FF")

FAMILIES = collections.OrderedDict([
    ("instrument-serif", ("Instrument Serif",
                          "'Instrument Serif', 'Iowan Old Style', 'Palatino Linotype', Georgia, serif",
                          [("400", "normal"), ("400", "italic")])),
    ("figtree", ("Figtree", "Figtree, system-ui, -apple-system, 'Segoe UI', sans-serif",
                 [("400", "normal"), ("500", "normal"), ("600", "normal")])),
    ("young-serif", ("Young Serif",
                     "'Young Serif', 'Iowan Old Style', 'Palatino Linotype', Georgia, serif",
                     [("400", "normal")])),
    ("instrument-sans", ("Instrument Sans",
                         "'Instrument Sans', system-ui, -apple-system, 'Segoe UI', sans-serif",
                         [("400", "normal"), ("500", "normal"), ("600", "normal")])),
    ("system", ("System sans", "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif", [])),
])

TYPE_SETS = collections.OrderedDict([
    ("type-1-editorial", ("Editorial", "instrument-serif", "figtree")),
    ("type-2-system", ("System fonts", "system", "system")),
    # Slab-ish serif headings over a neutral grotesque: shop signage, not fashion.
    ("type-3-roaster", ("Roaster", "young-serif", "instrument-sans")),
])

# A starter's look, as one style a person can also pick in the Site Editor
# without importing anything: a palette and a type pairing under the starter's
# own name.
STARTER_SETS = collections.OrderedDict([
    ("roastery", ("Roastery", "colors-8-espresso", "type-3-roaster")),
])


def fluid(minimum, maximum):
    return collections.OrderedDict([("min", minimum), ("max", maximum)])


FONT_SIZES = [
    ("Tiny",      "tiny",      "0.75rem",  None),
    ("Small",     "small",     "0.875rem", None),
    ("Medium",    "medium",    "1rem",     None),
    ("Large",     "large",     "1.125rem", fluid("1.0625rem", "1.25rem")),
    ("X Large",   "x-large",   "1.5rem",   fluid("1.3125rem", "1.625rem")),
    ("XX Large",  "xx-large",  "2.25rem",  fluid("1.875rem", "2.625rem")),
    ("Huge",      "huge",      "3.5rem",   fluid("2.5rem", "4rem")),
    ("Colossal",  "colossal",  "5.5rem",   fluid("3.25rem", "6.5rem")),
]

SPACING = [
    ("10", "0.25rem"),
    ("20", "0.5rem"),
    ("30", "1rem"),
    ("40", "1.5rem"),
    ("50", "clamp(1.75rem, 3vw, 2.5rem)"),
    ("60", "clamp(2.5rem, 5vw, 4rem)"),
    ("70", "clamp(3.5rem, 8vw, 6rem)"),
    ("80", "clamp(4.5rem, 11vw, 8.5rem)"),
]


# ---------------------------------------------------------------------------
# Contrast
# ---------------------------------------------------------------------------
def _channel(value):
    value = value / 255
    return value / 12.92 if value <= 0.04045 else ((value + 0.055) / 1.055) ** 2.4


def luminance(hex_colour):
    r, g, b = (int(hex_colour[i:i + 2], 16) for i in (1, 3, 5))
    return 0.2126 * _channel(r) + 0.7152 * _channel(g) + 0.0722 * _channel(b)


def contrast_ratio(a, b):
    la, lb = luminance(a), luminance(b)
    return (max(la, lb) + 0.05) / (min(la, lb) + 0.05)


def audit():
    problems = []
    for key, (name, colors) in COLOR_SETS.items():
        missing = [slug for _, slug in PALETTE if slug not in colors]
        extra = sorted(set(colors) - {slug for _, slug in PALETTE})
        if missing or extra:
            problems.append("%s: missing %s, unknown %s" % (name, missing, extra))
            continue
        worst = min((contrast_ratio(colors[fg], colors[bg]), fg, bg) for fg, bg in CONTRAST_CHECKS)
        for fg, bg in CONTRAST_CHECKS:
            ratio = contrast_ratio(colors[fg], colors[bg])
            if ratio < 4.5:
                problems.append("%s: %s on %s is %.2f:1" % (name, fg, bg, ratio))
        # A filled button has to read as a button against the page (WCAG 1.4.11).
        boundary = min(contrast_ratio(colors["primary"], colors["base"]),
                       contrast_ratio(colors["primary"], colors["surface"]))
        if boundary < 3:
            problems.append("%s: primary fill against the page is %.2f:1" % (name, boundary))
        print("  %-10s worst pair %-22s %5.2f:1   button edge %5.2f:1"
              % (name, "%s/%s" % (worst[1], worst[2]), worst[0], boundary))
    if problems:
        raise SystemExit("\nContrast failures:\n  " + "\n  ".join(problems))


# ---------------------------------------------------------------------------
# theme.json
# ---------------------------------------------------------------------------
def od(*pairs):
    return collections.OrderedDict(pairs)


def var(slug):
    return "var(--wp--preset--color--%s)" % slug


def fs(slug):
    return "var(--wp--preset--font-size--%s)" % slug


def ff(slug):
    return "var(--wp--preset--font-family--%s)" % slug


def sp(slug):
    valid = {s for s, _ in SPACING}
    if slug not in valid:
        raise SystemExit("spacing %r is not on the scale %s" % (slug, sorted(valid)))
    return "var(--wp--preset--spacing--%s)" % slug


def palette(colors):
    return [od(("name", name), ("slug", slug), ("color", colors[slug])) for name, slug in PALETTE]


def font_families():
    out = []
    for key, (name, stack, faces) in FAMILIES.items():
        entry = od(("name", name), ("slug", key), ("fontFamily", stack))
        if faces:
            entry["fontFace"] = []
            for weight, style in faces:
                for subset, unicode_range in (("latin", LATIN), ("latin-ext", LATIN_EXT)):
                    entry["fontFace"].append(od(
                        ("fontFamily", name), ("fontStyle", style), ("fontWeight", weight),
                        ("fontDisplay", "swap"),
                        ("src", ["file:./assets/fonts/%s-%s-%s-%s.woff2" % (key, subset, weight, style)]),
                        ("unicodeRange", unicode_range),
                    ))
        out.append(entry)
    return out


def build_settings():
    default = COLOR_SETS["colors-1-linen"][1]
    return od(
        ("appearanceTools", True),
        ("useRootPaddingAwareAlignments", True),
        ("layout", od(("contentSize", "760px"), ("wideSize", "1360px"))),
        ("color", od(("custom", True), ("defaultPalette", False), ("defaultGradients", False),
                     ("defaultDuotone", False), ("palette", palette(default)))),
        ("typography", od(
            ("fluid", od(("minViewportWidth", "360px"), ("maxViewportWidth", "1440px"))),
            ("customFontSize", True), ("defaultFontSizes", False), ("writingMode", True),
            ("fontFamilies", font_families()),
            ("fontSizes", [od(("name", name), ("slug", slug), ("size", size)) if not f else
                           od(("name", name), ("slug", slug), ("size", size), ("fluid", f))
                           for name, slug, size, f in FONT_SIZES]),
        )),
        ("spacing", od(("units", ["px", "em", "rem", "vh", "vw", "%"]),
                       ("defaultSpacingSizes", False),
                       ("spacingSizes", [od(("name", name), ("slug", name), ("size", size))
                                         for name, size in SPACING]))),
        ("shadow", od(("defaultPresets", False), ("presets", [
            od(("name", "Soft"), ("slug", "soft"), ("shadow", "0 1px 2px rgba(20, 16, 12, 0.06), 0 4px 16px rgba(20, 16, 12, 0.06)")),
            od(("name", "Lifted"), ("slug", "lifted"), ("shadow", "0 12px 40px rgba(20, 16, 12, 0.14)")),
        ]))),
        # Tokens the stylesheet reads, so a style variation can restyle
        # components that theme.json has no property for.
        ("custom", od(
            ("radius", od(("small", "4px"), ("medium", "10px"), ("large", "18px"), ("pill", "999px"))),
            ("media", od(("radius", "6px"), ("ratio", "4/5"))),
            ("header", od(("height", "72px"))),
            ("transition", "180ms cubic-bezier(0.2, 0, 0, 1)"),
        )),
    )


def build_styles():
    return od(
        ("color", od(("background", var("base")), ("text", var("contrast")))),
        ("typography", od(("fontFamily", ff("figtree")), ("fontSize", fs("medium")),
                          ("fontWeight", "400"), ("lineHeight", "1.6"))),
        ("spacing", od(("blockGap", sp("40")),
                       ("padding", od(("left", sp("40")), ("right", sp("40")))))),
        ("elements", od(
            ("heading", od(
                ("typography", od(("fontFamily", ff("instrument-serif")), ("fontWeight", "400"),
                                  ("lineHeight", "1.08"), ("letterSpacing", "-0.01em"))),
                ("color", od(("text", var("contrast")))),
            )),
            ("h1", od(("typography", od(("fontSize", fs("huge")))))),
            ("h2", od(("typography", od(("fontSize", fs("xx-large")))))),
            ("h3", od(("typography", od(("fontSize", fs("x-large")), ("lineHeight", "1.2"))))),
            ("h4", od(("typography", od(("fontSize", fs("large")), ("lineHeight", "1.3"))))),
            ("h5", od(("typography", od(("fontFamily", ff("figtree")), ("fontSize", fs("medium")),
                                        ("fontWeight", "600"), ("lineHeight", "1.4"))))),
            ("h6", od(("typography", od(("fontFamily", ff("figtree")), ("fontSize", fs("small")),
                                        ("fontWeight", "600"), ("lineHeight", "1.4"),
                                        ("textTransform", "uppercase"), ("letterSpacing", "0.08em"))))),
            ("link", od(
                ("color", od(("text", var("contrast")))),
                ("typography", od(("textDecoration", "underline"))),
                (":hover", od(("color", od(("text", var("primary-deep")))))),
            )),
            ("button", od(
                ("color", od(("background", var("primary")), ("text", var("on-primary")))),
                ("typography", od(("fontFamily", ff("figtree")), ("fontWeight", "500"),
                                  ("fontSize", fs("medium")), ("lineHeight", "1.2"))),
                ("border", od(("radius", "var(--wp--custom--radius--pill)"), ("width", "0"))),
                ("spacing", od(("padding", od(("top", "0.95rem"), ("bottom", "0.95rem"),
                                              ("left", "1.75rem"), ("right", "1.75rem"))))),
                (":hover", od(("color", od(("background", var("primary-deep")), ("text", var("on-primary")))))),
                (":focus", od(("outline", od(("color", var("contrast")), ("offset", "3px"),
                                             ("style", "solid"), ("width", "2px"))))),
            )),
            ("caption", od(("typography", od(("fontSize", fs("small")))), ("color", od(("text", var("muted")))))),
        )),
        ("blocks", od(
            ("core/site-title", od(("typography", od(("fontFamily", ff("instrument-serif")),
                                                     ("fontSize", fs("x-large")), ("fontWeight", "400"),
                                                     ("letterSpacing", "-0.01em"))),
                                   ("elements", od(("link", od(("typography", od(("textDecoration", "none"))))))))),
            ("core/navigation", od(("typography", od(("fontSize", fs("medium")), ("fontWeight", "500"))))),
            ("core/separator", od(("color", od(("text", var("divider")))))),
            ("core/quote", od(("typography", od(("fontFamily", ff("instrument-serif")), ("fontSize", fs("x-large")))))),
            ("core/pullquote", od(("typography", od(("fontFamily", ff("instrument-serif")), ("fontSize", fs("xx-large")))))),
            ("core/post-title", od(("elements", od(("link", od(("typography", od(("textDecoration", "none"))))))))),
            ("core/post-date", od(("typography", od(("fontSize", fs("small")))), ("color", od(("text", var("muted")))))),
            ("core/post-terms", od(("typography", od(("fontSize", fs("small")))))),
            ("core/image", od(("border", od(("radius", "var(--wp--custom--media--radius)"))))),
            ("woocommerce/product-price", od(("typography", od(("fontSize", fs("medium")))))),
        )),
    )


def build_theme():
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3),
        ("settings", build_settings()),
        ("styles", build_styles()),
        ("customTemplates", [
            od(("name", "page-no-title"), ("title", "Page without title"), ("postTypes", ["page"])),
            od(("name", "page-wide"), ("title", "Wide page"), ("postTypes", ["page"])),
        ]),
        ("templateParts", [
            od(("name", "header"), ("title", "Header"), ("area", "header")),
            od(("name", "footer"), ("title", "Footer"), ("area", "footer")),
            od(("name", "checkout-header"), ("title", "Checkout header"), ("area", "header")),
        ]),
    )


def build_color_variation(name, colors):
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("settings", od(("color", od(("palette", palette(colors)))))),
    )


def build_type_variation(name, heading, body):
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("styles", od(
            ("typography", od(("fontFamily", ff(body)))),
            ("elements", od(("heading", od(("typography", od(("fontFamily", ff(heading)))))))),
        )),
    )


def build_starter_variation(name, colors, heading, body):
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("settings", od(("color", od(("palette", palette(colors)))))),
        ("styles", od(
            ("typography", od(("fontFamily", ff(body)))),
            ("elements", od(("heading", od(("typography", od(("fontFamily", ff(heading)))))))),
        )),
    )


def write(path, data):
    os.makedirs(os.path.dirname(path) or ".", exist_ok=True)
    with open(path, "w", encoding="utf-8") as handle:
        json.dump(data, handle, indent="\t", ensure_ascii=False)
        handle.write("\n")
    return path


def font_files():
    """Every woff2 theme.json names, so build-fonts.mjs fetches exactly these."""
    files = []
    for key, (_, _, faces) in FAMILIES.items():
        for weight, style in faces:
            for subset in ("latin", "latin-ext"):
                files.append((key, subset, weight, style))
    return files


def main():
    audit()
    written = [write("theme.json", build_theme())]
    for slug, (name, colors) in COLOR_SETS.items():
        if slug == "colors-1-linen":
            continue  # the default lives in theme.json itself
        written.append(write("styles/colors/%s.json" % slug, build_color_variation(name, colors)))
    for slug, (name, heading, body) in TYPE_SETS.items():
        if slug == "type-1-editorial":
            continue
        written.append(write("styles/typography/%s.json" % slug, build_type_variation(name, heading, body)))
    for slug, (name, color_slug, type_slug) in STARTER_SETS.items():
        colors = COLOR_SETS[color_slug][1]
        heading, body = TYPE_SETS[type_slug][1], TYPE_SETS[type_slug][2]
        written.append(write("styles/starters/%s.json" % slug,
                             build_starter_variation(name, colors, heading, body)))
    write(".dev/fonts.json", [od(("family", k), ("subset", s), ("weight", w), ("style", st))
                               for k, s, w, st in font_files()])
    print("\n  %d files written" % len(written))


if __name__ == "__main__":
    main()
