# Security & Error Handling Manifesto

## Data Protection
- **Input:** Sanitize all incoming data. Use `filter_var()` or custom validators in the Domain layer.
- **Output (XSS):** Rely on Smarty auto-escaping. Explicitly use `|escape` for sensitive HTML output.
- **Secrets:** Database credentials and API keys must stay in `.env`. Never commit them to Git.

## Error Handling
- **No Silencing:** Never use the `@` operator.
- **Exceptions:** Use custom Domain Exceptions (e.g., `ArticleNotFoundException`).
- **Global Catch:** The Front Controller must have a global `try-catch` block to log errors and show a clean "500 Error" page to the user without leaking system paths.