# 2026-04-01: Database Seeding Implementation

## Technical Decisions (ADR Style)

1.  **Direct PDO Usage:** For the seed script, I used direct PDO interaction via the `Container` to handle bulk inserts and schema resets efficiently without overhead.
2.  **Schema Preparation:** Implemented `TRUNCATE` for `categories`, `articles`, and the pivot `article_category` table with `SET FOREIGN_KEY_CHECKS = 0` to ensure a clean state before every run.
3.  **Randomized Data Generation:** 
    - Articles are assigned to **1-2 random categories** to test the Many-to-Many relationship.
    - `view_count` and `published_at` are randomized (last 180 days) to allow realistic testing of sorting (Top Posts, Latest Posts).
4.  **Security:** Used strictly **Prepared Statements** for all insertions, adhering to Rule [Security] from `GEMINI.md`.
5.  **High-Quality Content:** Seeded 5 distinct categories and 7 high-quality articles with Unsplash images to ensure the UI looks premium immediately.

## Modified/Created Files

- `bin/seed.php` [NEW]
- `.obsidian_vault/Current_Task.md` [MODIFY] (Marked completed)

## Potential Technical Debt & Future Optimizations

- **Faker Library:** Currently, data is hardcoded or semi-random. If we need 100+ articles, integrating a library like `fakerphp/faker` would be ideal.
- **Image Variety:** Using a limited set of Unsplash URLs; could be expanded for more visual variety in the `MainPageAction` testing.

---
*Created by Antigravity (AI Agent).*
