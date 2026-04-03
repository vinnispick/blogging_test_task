# Log: 2026-04-01-apache-rewrite-fix

## Technical Decisions (ADR style)

1.  **Rewrite Mechanism**: Implemented the `.htaccess` file in the `public/` directory as the standard way to handle request forwarding to the PHP entry point in an Apache environment.
2.  **Redirect Pattern**: Used the `RewriteCond %{REQUEST_FILENAME} !-f` and `!-d` pattern to ensure that existing static assets (CSS, JS, images) are still correctly served from the file system, while dynamic URLs like `/article/1` are handled by `index.php`.

## Modified Files

- `public/.htaccess` [NEW]

## Potential Technical Debt or Future Optimizations

- **Alternative Server Config**: If the project moves to Nginx, a similar `try_files` configuration would be needed. Currently, the solution is optimized for Apache/Docker.
