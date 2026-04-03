# Log: 2026-04-03 - Strict Type Checking Refactor

## Technical Decisions (ADR Style)
* **Decision:** Convert all loose comparisons (`==`, `!=`) and truthy/falsy checks (e.g., `if (!$var)`) to strict comparisons (e.g., `===`, `!==`).
* **Rationale:** Aligns with Rule [GEMINI.md] for strict typing and Senior-level code quality. Reduces bugs related to PHP's type juggling.
* **Implementation:**
    * Updated `PDO::fetch()` result checks to `=== false`.
    * Updated `in_array()` to use the third parameter `true` for strict search.
    * Updated `if (!$category)` and `if (!$article)` checks to `=== null` where applicable.
    * Updated AJAX header and request parameter checks to be explicit booelan comparisons.

## Modified Files
* `src/Infrastructure/Persistence/Pdo/PdoArticleRepository.php`
* `src/Infrastructure/Persistence/Pdo/PdoCategoryRepository.php`
* `src/Core/Router.php`
* `src/Core/SecurityUtil.php`
* `src/Presentation/Web/Action/ArticlePageAction.php`
* `src/Presentation/Web/Action/CategoryPageAction.php`
* `src/Domain/Service/ArticleService.php`
* `public/index.php`

## Potential Technical Debt or Future Optimizations
* The codebase is now highly consistent with strict typing. Future work should maintain this by avoiding new loose comparisons.
