# Log: Router Implementation

## Technical Decisions (ADR style)

### 1. Reusable Router Component
**Decision**: Implement a dedicated `Router` class in `src/Core` to handle URL-to-Action mapping.
**Rationale**: The previous hardcoded `if-elseif-else` block in `public/index.php` was not scalable and violated the Open/Closed principle. A reusable router allows for dynamic route registration and better separation of concerns.

### 2. Regular Expression Based Matching
**Decision**: Use regular expressions to match URI patterns and extract dynamic parameters (e.g., `{id}`).
**Rationale**: This provides a flexible and powerful way to define routes with placeholders without manual `preg_match` calls in the entry point.

### 3. Named Routes
**Decision**: Support naming routes and provide a `generateUrl` method.
**Rationale**: This enables reverse URL generation, which reduces hardcoded URLs in templates and actions, making the application more maintainable.

### 4. Integration with Container
**Decision**: Register the `Router` as a service in the `Container` and configure routes during bootstrap.
**Rationale**: This follows the established DI pattern and makes the router available throughout the application (e.g., for `Responder` to generate links).

## Modified Files
- `src/Core/Router.php` [NEW]
- `src/Core/Container.php` [MODIFY]
- `public/index.php` [MODIFY]
- `.obsidian_vault/Current_Task.md` [MODIFY]

## Potential Technical Debt or Future Optimizations
- **Middleware Support**: The router is currently a simple dispatcher. Adding a middleware stack would allow for cross-cutting concerns like authentication or CSRF protection.
- **Route Caching**: For large numbers of routes, compiling and caching the regex map could improve performance.
- **Advanced Parameter Constraints**: Currently, placeholders like `{id}` match any non-slash character. Supporting constraints like `{id:\d+}` would be a good enhancement.
- **URL Generation in Templates**: We should expose the `generateUrl` method to Smarty templates for clean link generation.
