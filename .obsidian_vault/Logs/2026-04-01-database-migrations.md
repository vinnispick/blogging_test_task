# Log: 2026-04-01 Database Migrations

## Technical Decisions (ADR)

1.  **Direct SQL approach**: Migrations are written in plain SQL for maximum compatibility with the lightweight nature of the project.
2.  **Custom PHP Runner**: Implemented `bin/migrate.php` using the existing `App\Core\Container`. This follows the project's goal of "Senior-level skills without frameworks".
3.  **State Tracking**: Added a `_migrations` table to track applied scripts, ensuring idempotency.
4.  **Makefile Integration**: Added `make migrate` to the development workflow.

## Modified Files

- `migrations/001_initial_schema.sql` [NEW]
- `bin/migrate.php` [NEW]
- `Makefile` [MODIFY]
- `.obsidian_vault/Current_Task.md` [MODIFY]

## Potential Technical Debt / Future Optimizations

- **Rollbacks**: The current system doesn't support "down" migrations. This could be added if needed.
- **Transactional Migrations**: For more complex migrations, wrapping each file in a transaction would be safer (though DDL doesn't always support transactions in MySQL).
- **Phinx or similar**: If the project grows significantly, switching to a dedicated migration tool might be beneficial, but for now, the current solution fits the constraints perfectly.
