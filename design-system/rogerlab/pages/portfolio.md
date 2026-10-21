# Portfolio overrides

Inherits [MASTER.md](../MASTER.md). Applies to all portfolio routes.

## Composition

- Frame: compact wordmark/header, sticky navigation and horizontal preferences.
- Home: the name is the main headline, the full professional role its supporting
  line; identity, portrait and CV actions remain visible. The stack comes from
  published, ordered skills. A discovery carousel follows the hero,
  alternating up to four featured projects and four recent blog posts.
  The complete introduction remains below in two columns on desktop.
- Projects: unboxed, full-width case-study rows, media beside the complete description;
  galleries remain keyboard-operable controls with their existing lightbox.
- Skills: typographic directory in a responsive grid, not proficiency meters.
- Methodology: two complementary text columns beneath the directory.
- Contact: title beside the form on desktop; stacked on phones.
- FCT, blog and legal: readable document layouts using the shared type scale.
- Footer: contact details lead on the page ground; legal navigation remains available.
- Frame: maximum 1480px, matching outer gutters. Active navigation uses the inverse
  action colors. Open document layouts, square media and generous type replace
  unnecessary raised text panels without changing the charcoal/ivory palette.

## Responsive behavior

- Base layout is single-column, 20px gutters.
- 48rem: wider navigation and multi-column content when it fits.
- Desktop portrait is alongside identity; mobile portrait follows actions.
- No nested page scroll regions, fixed-height text panels or clipped copy.
- Do not enforce two-line headings by truncating or changing original copy.
- Below 48rem, preferences use moon/sun and play/pause line icons with 44px
  touch targets at every width. Labels stay visually hidden and available to
  assistive technology on desktop as well. All labels follow the ES/EN/PT locale.
- Playback shows pause while running and play while paused, preserving the
  saved preference. Reduced motion and WebGL context loss have explicit labels.
- Sticky navigation uses an opaque page-colored band extending across the
  frame gutters, including the expanded mobile menu, without blur or particles
  showing through its surface.

## Deliberate boundaries

The original multipage/partial-navigation architecture is not turned into a
new one-page site. Each route keeps its content and destinations.
Do not add four unrelated images to the home page solely to satisfy a visual
inspector; project screenshots remain on the projects route.
Existing galleries and the discovery carousel supply the live interaction.
The carousel advances after eight seconds of reading time, with no visible
heading, intro, scrollbar, link row, counter or previous/next buttons, as requested.
Navigation uses small outlined dots with an elongated filled capsule for the
active slide, matching the user's reference. Each has a 44px target and localized
accessible name; selecting one jumps to that item and pauses until explicit resume.
The icon-only playback control remains alongside them. Indicators follow autoplay,
native scrolling and keyboard navigation, wrapping on narrow screens if needed.
Hover, touch, hidden tabs and offscreen content suspend playback. Keyboard focus
stops it until explicit resume. Reduced motion disables autoplay completely.
Automatic changes are not announced as live updates. Single-item content has no
playback control. Partial navigation disposes timers, listeners and observers.
Without JavaScript it remains a horizontally scrollable, readable collection.
Project details have localized canonical/hreflang, social metadata, CreativeWork
JSON-LD and sitemap entries. Partial navigation replaces the complete SEO head.
No new gimmick or scroll scene.
Visual-inspector exceptions preserve the approved system: original long project titles,
ivory/charcoal palette, and limited motion/video policy remain unchanged. Do not
add unrelated photos to meet a picture-count floor. Native carousel overflow is
intentional; offscreen slide coordinates are not page margin errors. The skill
directory is content, not an eyebrow for the following discovery section.
The same applies to the final Docker entry before the methodology section.
The contact inspector's empty-screen heuristic does not count form fields;
keep the real, labeled form instead of adding filler imagery or sales copy.
Document pages intentionally prioritize reading rather than a first-fold CTA.
The homepage role is set immediately under the name at lead size; a name-only
warning is not evidence that the professional role is missing.
The user's original particle background is restored by explicit request,
subordinate to text and project media. It is decorative, ignores pointer
events, and has pause/reduced-motion/hidden-tab fallbacks.
