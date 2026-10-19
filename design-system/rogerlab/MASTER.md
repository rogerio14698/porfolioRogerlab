# RogerLab / Design system master

Generated with UI UX Pro Max on 2026-10-19, then adapted to the existing brand.
Read [portfolio overrides](pages/portfolio.md) after this master.
Source of truth: `resources/sass/global/_tokens.scss`.

## Direction

A professional dossier, grounded in Rogerio's actual work, portrait and FCT.
Keep the charcoal/ivory identity, complete ES/EN/PT copy and existing routes.
The generator's blue accent, brutalism, serif/mono combination and parallax
are deliberately rejected: they conflict with the brief and reading comfort.
Taste direction: `page-is-the-object`, seed `1081985591`.
The CV/dossier is the compositional reference, not a simulated paper UI.

## Three token layers

1. Primitives: `--palette-*`, `--space-*`, font families, sizes, radii, durations.
2. Semantics: `--surface-*`, `--text-*`, `--action-*`, `--focus-ring`.
3. Components: `--button-bg`, `--button-text`, `--card-bg`, `--input-bg`.

Existing `--_fondo`, `--_texto` aliases remain compatible with legacy components.

| Role | Dark | Light |
| --- | --- | --- |
| Page | #222222 | #ECE8DF |
| Raised surface | #333333 | #FFFFFF |
| Primary text | #DDDDDD | #1F1F1F |
| Secondary text | #DDDDDD | #444444 |
| Action | #ECE8DF | #222222 |
| Action text | #1F1F1F | #ECE8DF |
| Focus | #ECE8DF | #222222 |
| Field border | #999999 | #444444 |

No new accent hue. Project images retain their original colors.
Text and placeholders must meet 4.5:1; large type 3:1.

## Typography

- Big Shoulders 600: display and section titles, sentence case.
- Public Sans 400/600: body, navigation, controls and metadata.
- Body 16px, 1.65 line height; reading measure approximately 65ch.
- Small 14px; lead 18-22px; headings 28-48px; display 36-76px.
- No monospace outside literal code. No uppercase transformations.
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

## Assets

Use only the existing portrait, project logos and real screenshots.
Do not invent claims, projects, captions, statistics or external photography.
No video: none belongs to the current project content.
No new UI, animation or font dependency.
