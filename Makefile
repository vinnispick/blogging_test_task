# Blog Engine Makefile

.PHONY: help serve seed scss-compile scss-watch setup migrate

# Default target
help:
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@echo "  serve          Start the PHP development server"
	@echo "  migrate        Run pending database migrations"
	@echo "  seed           Reset and seed the database"
	@echo "  scss-compile   Compile SCSS to CSS once"
	@echo "  scss-watch     Watch SCSS and compile on change"
	@echo "  setup          Install dependencies and setup environment"

# Start PHP Server
serve:
	@echo "Starting server at http://localhost:8000"
	@php -S localhost:8000 -t public/

# Database Migrations
migrate:
	@echo "Running migrations..."
	@php bin/migrate.php

# Database Seeding
seed:
	@echo "Seeding database..."
	@php bin/seed.php

# SCSS Compilation
scss-compile:
	@echo "Compiling SCSS..."
	@npx -y sass public/static/scss/main.scss public/static/css/main.css

scss-watch:
	@echo "Watching SCSS..."
	@npx -y sass --watch public/static/scss/main.scss public/static/css/main.css

# Initial Project Setup
setup:
	@echo "Setting up project..."
	@composer install
	@if [ ! -f .env ]; then cp .env.example .env; fi
	@$(MAKE) scss-compile
	@echo "Setup complete. Run 'make serve' to start."

# Docker Orchestration
docker-build:
        @echo "Building Docker images..."
        @docker compose build

docker-up:
	@echo "Starting Docker containers..."
	@docker compose up -d

docker-down:
	@echo "Stopping Docker containers..."
	@docker compose down

docker-seed:
	@echo "Seeding database inside container..."
	@docker exec -it blog_app php bin/seed.php

docker-bash:
	@docker exec -it blog_app bash
