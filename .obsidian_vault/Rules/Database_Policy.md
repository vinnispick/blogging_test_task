# Database Policy: MySQL High-Performance Standards

## Schema First
- **Rule:** Update `.obsidian_vault/Docs/Database_Schema.md` before changing any PHP Repository code.
- **Engine:** Use `InnoDB` with `utf8mb4_unicode_ci` charset.

## Naming Conventions
- Tables: `snake_case` and plural (e.g., `articles`).
- Columns: `snake_case` and singular (e.g., `view_count`).
- Foreign Keys: `table_singular_id` (e.g., `category_id`).

## Integrity & Performance
- **Timestamps:** Every table must have `created_at` and `updated_at`.
- **Persistence:** Strictly use **PDO with Prepared Statements**. No raw SQL concatenation.
- **Indexing:** - Every Foreign Key must have an index.
    - Columns used in `ORDER BY` or `WHERE` clauses (like `published_at`) must be indexed.
    - Use `EXPLAIN` to verify query performance for complex joins.