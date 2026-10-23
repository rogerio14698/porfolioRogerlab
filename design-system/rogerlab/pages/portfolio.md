# Portfolio overrides

Inherits [MASTER.md](../MASTER.md). Applies to all portfolio routes.

## Composition

- Frame: compact wordmark/header, sticky navigation and horizontal preferences.
- Home: the name is the main headline, followed by the role and Laravel/PHP
  focus, a personal sentence and availability for employment/freelance. Projects are
  the primary action; both CVs remain available with English first in EN and
  Spanish first in ES/PT. The portrait can be replaced or removed from the panel.
  Three contribution rows explain the work and link to published evidence:
  custom development, maintenance/technical SEO and n8n automation.
  Each area accepts multiple projects, with compact linked covers when available
  and text-only links otherwise. Use native checkboxes in the profile editor.
  Tools move to About rather than crowding the hero. The research note and
  discovery carousel follow, using the managed carousel selection.
  The complete, editable biography remains below in two columns on desktop.
  Research describes learning in progress, never established commercial expertise.
  All profile copy and SEO come from the localized server-rendered profile.
- Projects: unboxed, full-width case-study rows, media beside the existing summary
  (complete description when no summary exists). Detail pages retain all content
  and open with the title and context before the cover image;
  galleries remain keyboard-operable controls with their existing lightbox.
- Skills: typographic directory in a responsive grid, not proficiency meters.
- Methodology: two complementary text columns before the technology directory,
  with short localized headings and the current research.
- Contact: title, audience context and optional subject shortcuts beside the form
  on desktop; stacked on phones. Shortcuts fill only an empty subject and focus
  that field; they never replace visitor text or change the verification flow.
  Without JavaScript the shortcuts are hidden and the normal form remains usable.
- FCT, blog and legal: readable document layouts using the shared type scale.
- Footer: contact details lead on the page ground; legal navigation remains available.
- Frame: maximum 1480px, matching outer gutters. Active navigation uses the inverse
  action colors. Open document layouts, square media and generous type replace
  unnecessary raised text panels within the graphite/mineral-green palette.

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
inspector; only selected evidence projects add screenshots to contribution rows.
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
terminal monospace titles, and limited motion/video policy remain unchanged. Do not
add unrelated photos to meet a picture-count floor. Native carousel overflow is
intentional; offscreen slide coordinates are not page margin errors. The skill
directory is content, not an eyebrow for the following discovery section.
The contact inspector's empty-screen heuristic does not count form fields;
keep the real, labeled form instead of adding filler imagery or sales copy.
Document pages intentionally prioritize reading rather than a first-fold CTA.
The homepage role is set immediately under the name at lead size; a name-only
warning is not evidence that the professional role is missing.
Short contact and project-detail pages deliberately do not animate eight elements
to satisfy a marketing-page counter. The actual particle background and existing
entrances remain; the contact form fields count as content even when the inspector's
empty-screen heuristic ignores them.
The user's original particle background is restored by explicit request,
subordinate to text and project media. It is decorative, ignores pointer
events, and has pause/reduced-motion/hidden-tab fallbacks.
