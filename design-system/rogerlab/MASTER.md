# RogerLab / Design system master

Updated on 2026-10-23 after the terminal direction was approved.
Read [portfolio overrides](pages/portfolio.md) after this master.
Source of truth: `resources/sass/global/_tokens.scss`.

## Direction

A restrained professional terminal, grounded in Rogerio's real projects,
independent research, portrait and FCT. Employment is the primary audience;
business projects share a clear contact path, not a separate agency identity.
The owner is open to employment and freelance work from Asturias and remotely
in Spain and internationally. Do not imply established WordPress experience.
Keep complete ES/EN/PT support, existing routes, galleries and administration.
Taste reference: `quiet-instrument`, seed `925619899`. The approved brief overrides
the dealt newsprint palette, display font, stock photographs and narrow-column
layout: graphite/mint, JetBrains Mono/Public Sans and existing assets only.
No simulated shell, typing gate, fake commands, neon glow or invented proof.

## Three token layers

1. Primitives: `--palette-*`, `--space-*`, font families, sizes, radii, durations.
2. Semantics: `--surface-*`, `--text-*`, `--action-*`, `--focus-ring`.
3. Components: `--button-bg`, `--button-text`, `--card-bg`, `--input-bg`.

Existing `--_fondo`, `--_texto` aliases remain compatible with legacy components.

| Role | Dark | Light |
| --- | --- | --- |
| Page | #101715 | #F4F7F5 |
| Raised surface | #19221D | #FFFFFF |
| Primary text | #E7EEE9 | #18251E |
| Secondary text | #A4B4AA | #51695B |
| Action | #86C7A3 | #246342 |
| Action text | #18251E | #FFFFFF |
| Focus | #86C7A3 | #246342 |
| Field border | #82998C | #51695B |

The mineral-green accent identifies actions, focus and selected states.
Project images retain their original colors.
Text and placeholders must meet 4.5:1; large type 3:1.

## Typography

- JetBrains Mono 600: display and section titles, sentence case.
- Public Sans 400/600: body, navigation, controls and metadata.
- Body 16px, 1.65 line height; reading measure approximately 65ch.
- Small 14px; lead 18-22px; section headings 22-32px; page titles 30-52px.
- Home name 36-72px. Monospace is an explicit user-approved terminal signature;
  long-form copy stays in Public Sans. Both families are self-hosted with OFL.
- No uppercase transformations.
- Preserve every original word and translation, even where long headings wrap.

## Space and shape

- 4px base; 4 / 8 / 12 / 16 / 24 / 32 / 48 / 64 / 96px.
- Shared fluid outer gutter 20-64px; section rhythm 48-96px.
- Square controls and media. Surface tone and space replace decorative borders.
- No shadow at rest. Dialog only: `0 24px 80px rgb(0 0 0 / 28%)`.

## States and accessibility

- Interactive targets at least 44px. Focus: 2px, offset 4px.
- Primary actions have an inverse solid fill; secondary actions a tone step.
- Hover and pressed feedback must not reveal otherwise inaccessible content.
- Entrance: 600ms ease-out, 16px maximum travel. Feedback: 160ms.
- Reduced motion: static readable final state, no typewriter or parallax.
- Plain HTML is fully readable without animation or JavaScript.
- Preserve form validation, Turnstile, routing, downloads and translation keys.
- Navigation supports keyboard, current page, mobile expansion and Escape.
- Navigation stays sticky at the top while reading long pages, on all routes.
- The original WebGL particle background is retained at low intensity:
  opacity 0.10/screen in dark mode and 0.06/multiply in light mode.
  Cap rendering at 30fps and device pixel ratio at 1. Stop the loop in hidden
  tabs, under reduced motion or when paused. Reduced motion keeps a still.
  A localized pressed-state button controls playback and remembers the choice.

## Assets

Use only the existing portrait, project logos and real screenshots.
Do not invent claims, projects, captions, statistics or external photography.
No video: none belongs to the current project content.
No new UI or animation dependency. JetBrains Mono is a local font asset,
not a runtime dependency or external font request.

## Editable portfolio and administration

The home page explains three contribution areas rather than showing a technology
pile: custom web development, maintenance/technical SEO and n8n automation.
Each area has meaningful copy and optional evidence from multiple published
projects: compact linked covers with titles, or text links when no cover exists.
Existing tools remain managed and move to About. Home biography and research
are server-rendered from the localized profile, never overwritten by client copy.

Administration is Operate mode, not a public landing page: Public Sans for titles
and controls, a fixed small heading scale, quiet current navigation and no
particles or entrance choreography. The existing graphite/mineral-green tokens,
square controls and local fonts remain. Use a labelled sidebar at desktop and
a native disclosure menu on phones/tablets. Keep real content and task links,
not invented metrics or decorative icons.

Profile editing groups presentation, contribution areas, biography, research,
photo and SEO into named disclosures, then languages. The current language is
open by default. Validation opens affected disclosures; destructive actions
stay separate and require confirmation. Saving publishes immediately and says so.
