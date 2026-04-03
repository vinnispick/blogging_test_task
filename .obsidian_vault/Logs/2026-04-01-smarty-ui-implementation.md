# 2026-04-01: Smarty UI, SCSS & Front Controller Implementation

## Technical Decisions (ADR Style)

1.  **SCSS Architecture:** Switched from Vanilla CSS to **SCSS** for better modularity and maintainability. Implemented a custom design system with **Inter** and **Outfit** typography and a **Deep Violet-to-Blue** accent palette.
2.  **Sass Build Step:** Integrated `npx -y sass` for compilation. This ensures the delivery layer always uses a single, optimized `main.css` file while keeping the source code clean in `.scss`.
3.  **Full Smarty Responder:** Upgraded `HtmlResponder` from a placeholder to a full engine. It now handles data assignment, template display, and unified error rendering.
4.  **Component-Based Templating:** Introduced a `components/` directory in templates. Reused the `_article_card.tpl` across both Main and Category pages to maintain UI consistency and reduce code duplication.
5.  **Front Controller (index.php):** Implemented a basic **Front Controller** in `public/index.php`. It handles URI routing and parameter mapping (e.g., `/category/{id}`) to Action classes.

## Modified/Created Files

- `src/Core/Container.php` [MODIFY] (Smarty injection)
- `src/Responder/HtmlResponder.php` [MODIFY] (Full implementation)
- `static/scss/main.scss` [NEW] (Design system)
- `static/css/main.css` [NEW] (Compiled styles)
- `templates/layout.tpl` [MODIFY] (Master layout)
- `templates/main_page.tpl` [NEW] (Home page)
- `templates/category_page.tpl` [NEW] (Category page)
- `templates/components/_article_card.tpl` [NEW] (Reusable article card)
- `templates/error.tpl` [NEW] (Unified error page)
- `public/index.php` [NEW] (Router/Front Controller)
- `.obsidian_vault/Current_Task.md` [MODIFY] (Marked completed)

## Potential Technical Debt & Future Optimizations

- **Dynamic Navigation:** The navigation bar currently has hardcoded category links. This should be made dynamic by fetching all categories in a "Global View Load" step.
- **Cache Warming:** `templates_c` and `cache` directories are being used by Smarty. For production, these should be pre-compiled.

---
*Created by Antigravity (AI Agent).*
