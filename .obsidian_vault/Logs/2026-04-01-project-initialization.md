# 2026-04-01: Project Initialization

## Technical Decisions (ADR Style)

1.  **Strict Action-Domain-Responder (ADR):** Implementation follows the Architecture Manifesto. Each request is a standalone Action.
2.  **No Frameworks:** Chose a manual DI Container (`src/Core/Container.php`) for speed, flexibility, and compliance with the "Senior-level" architectural requirement.
3.  **Strict Typing:** PHP 8.1+ `readonly` properties, `match` expressions, and explicit type declarations are mandatory for all core components.
4.  **Database Persistence:** MySQL via PDO with Prepared Statements for maximum security and performance.
5.  **Smarty Templates:** Centralized templating with logic-less `.tpl` files and auto-escaping.

## Modified/Created Files

- `composer.json` (PSR-4 autoloading, dependencies).
- `/src/Core/Container.php` (Manual DI Container).
- `/public/index.php` (Front Controller + match router).
- `/.env` & `.env.example` (Database & App config).
- `/templates/layout.tpl` (Base UI structure).
- `/.obsidian_vault/Docs/Database_Schema.md` (Mermaid & SQL DDL).

## Potential Technical Debt & Future Optimizations

- **Router Complexity:** The current `match` router in `index.php` is simple and fast for MVPs, but as the project grows, extracting a more robust Router service would be beneficial.
- **Service Registration:** Services are currently hardcoded in `Container::bootstrap()`. Consider moving them to a more modular configuration (XML/YAML/PHP) if the number of dependencies increases.
- **Seeder Integration:** The development protocol mentions a robust Seeder script, which will be implemented in the next phase.
- **Middlewares:** Currently, no middleware support exists for things like logging or authentication, which should be added if needed for future features.

---
*Created by Antigravity (AI Agent).*
