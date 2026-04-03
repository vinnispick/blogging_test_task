# 2026-04-01: Repository & Entity Implementation

## Technical Decisions (ADR Style)

1.  **Entities Over Arrays:** Following user request, implemented PHP 8.1+ `readonly` property entities (`Category` and `Article`). This ensures immutability and high type safety in the domain layer.
2.  **Pretty-Coded Structure:** Entities use `Constructor Promotion` for cleaner code and strict typing.
3.  **Repository Pattern:** Isolated data access logic in `CategoryRepository` and `ArticleRepository`. They are responsible for executing SQL and mapping results to entities.
4.  **SQL Separation:** SQL queries are extracted from docs and implemented with **PDO Prepared Statements** for security and performance.
5.  **Many-to-Many Handling:** `ArticleRepository` implements logic to fetch associated categories and find similar articles based on shared categories.
6.  **Architecture Update:** Formally added the **Entities** section to the `Architecture_Manifesto.md` to govern future data model development.

## Modified/Created Files

- `src/Domain/Category.php` [NEW]
- `src/Domain/Article.php` [NEW]
- `src/Domain/CategoryRepository.php` [NEW]
- `src/Domain/ArticleRepository.php` [NEW]
- `src/Core/Container.php` [MODIFY] (Registered repositories)
- `.obsidian_vault/Rules/Architecture_Manifesto.md` [MODIFY] (Added Entities section)

## Potential Technical Debt & Future Optimizations

- **PHP Compatibility:** Initial use of `readonly class` (PHP 8.2+) was downgraded to `readonly` properties for better PHP 8.1 compatibility.
- **SQL Optimization:** Some queries use `JOIN` and `LIMIT`. As the dataset grows, ensuring indices on `published_at` and `view_count` is critical (already planned in `Database_Schema.md`).
- **Data Mapper:** For now, mapping is done directly in the repositories. If complexity grows, a dedicated Mapper service could be introduced.

---
*Created by Antigravity (AI Agent).*
