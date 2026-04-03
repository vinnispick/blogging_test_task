# Log: Docker Composer & Migration Automation

**Date:** 2026-04-03
**Feature:** Phase 12 Deployment Enhancements

## Technical Decisions (ADR)

### 1. In-Docker Composer Installation
- **Problem:** Deployment required manual `composer install` on the host, which is inconsistent with a fully containerized workflow.
- **Solution:** Modified `Dockerfile` to include the `composer` binary from the official image and run `composer install` during the build process.
- **Benefit:** The Docker image is now self-contained and ready to run immediately after building.

### 2. Automated Database Migrations
- **Problem:** Database migrations had to be run manually after starting containers, leading to potential "out-of-sync" states for new deployments.
- **Solution:** Introduced a `bin/docker-entrypoint.sh` script that waits for the MySQL service to become reachable (via a PHP-based connection loop) and then runs `php bin/migrate.php` before starting the Apache server.
- **Constraint:** Used `exec apache2-foreground` at the end of the script to ensure signals are correctly passed to the Apache process.

### 3. Anonymous Volume for `vendor`
- **Problem:** The host mount `.:/var/www/html` in `docker-compose.yml` would overwrite the `vendor` folder created during the build process if the host directory was empty.
- **Solution:** Added an anonymous volume mount for `/var/www/html/vendor` in `docker-compose.yml`. This ensures the container preserves its internal `vendor` state regardless of the host's local files.

## Modified Files
- `Dockerfile`: Integrated Composer and entrypoint logic.
- `docker-compose.yml`: Added DB environment variables and anonymous volume.
- `bin/docker-entrypoint.sh`: New entrypoint script for DB waiting and migrations.

## Potential Technical Debt / Future Optimizations
- **Seeding:** Currently, migrations are automated but seeding (`bin/seed.php`) remains manual (as per request). We could add an environment variable check (e.g., `SEED_DATABASE=true`) to optionally automate seeding on first run.
- **Healthchecks:** Implement native Docker healthchecks for the `db` service to simplify the waiting logic in the app container.
