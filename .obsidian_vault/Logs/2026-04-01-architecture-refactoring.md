# Log: 2026-04-01 - Architecture Refactoring (Phase 10)

## Technical Decisions Made (ADR STYLE)
- **Layered Architecture Implementation**: Split the flat `src` structure into four distinct layers: `Domain`, `Application`, `Infrastructure`, and `Presentation`. This enforces a clear separation of concerns.
- **Dependency Inversion (DIP)**: Introduced `ArticleRepositoryInterface` and `CategoryRepositoryInterface`. High-level modules (Services/Actions) now depend on these abstractions rather than concrete `PDO` implementations. 
- **Namespace Structuring**: Migrated to a hierarchical namespace model (e.g., `App\Domain\Entity`, `App\Infrastructure\Persistence\Pdo`). This improves discoverability and aligns with PSR-4 standards for larger projects.
- **DTO Separation**: Moved `PaginationResult` and `ArticleByCategory` to the `Application\DTO` layer, acknowledging their role as cross-layer data carriers.
- **Action/Responder refinement**: Modernized the ADR (Action-Domain-Responder) pattern by moving web-specific logic to `App\Presentation\Web`.

## Modified Files (Summary)
- **New Structure Created**: `src/Domain/Entity`, `src/Domain/Repository`, `src/Domain/Service`, `src/Infrastructure/Persistence/Pdo`, `src/Application/DTO`, `src/Presentation/Web/Action`, `src/Presentation/Web/Responder`.
- **Refactored/Moved**: 
    - Entities: `Article`, `Category`
    - DTOs: `PaginationResult`, `ArticleByCategory`
    - Logic: `ArticleService`, `MainPageAction`, `CategoryPageAction`, `ArticlePageAction`
    - Core: `Container`, `index.php`
- **Deleted**: All legacy files in the flat `src` directory.

## Potential Technical Debt or Future Optimizations
- **Testing**: The current environment lacked `pdo_mysql` for runtime verification of the seeding script, though syntax validation was performed. Integration tests should be prioritized.
- **Entities**: Entities are currently simple property holders (Anemic Domain Model). Future work could involve moving business logic (like reading time calculation) into the `Article` entity.
- **Migrations**: CLI scripts (`bin/`) could be further refactored to use the new Repository interfaces instead of raw PDO.
