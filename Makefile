.PHONY: help install serve migrate seed test lint format clean

help:
	@echo "=== SIMASPIRASI IMIGRASI - Development Commands ==="
	@echo ""
	@echo "Setup Commands:"
	@echo "  make install          - Install dependencies (composer install)"
	@echo "  make migrate          - Run database migrations"
	@echo "  make seed             - Seed database with test data"
	@echo "  make fresh            - Fresh migrate + seed"
	@echo ""
	@echo "Development:"
	@echo "  make serve            - Start Laravel development server"
	@echo "  make tinker           - Start Laravel REPL"
	@echo ""
	@echo "Database:"
	@echo "  make migrate-rollback - Rollback last migration"
	@echo "  make migrate-refresh  - Refresh all migrations"
	@echo ""
	@echo "Docker Commands:"
	@echo "  make docker-up        - Start Docker containers"
	@echo "  make docker-down      - Stop Docker containers"
	@echo "  make docker-logs      - View Docker logs"
	@echo "  make docker-shell     - Shell into app container"
	@echo ""
	@echo "Code Quality:"
	@echo "  make lint             - Run PHP linter"
	@echo "  make format           - Format code with PSR-12"
	@echo "  make test             - Run PHPUnit tests"
	@echo ""
	@echo "Maintenance:"
	@echo "  make clear-cache      - Clear all caches"
	@echo "  make clean            - Clean storage directories"
	@echo ""

install:
	composer install

serve:
	php artisan serve

tinker:
	php artisan tinker

migrate:
	php artisan migrate

migrate-rollback:
	php artisan migrate:rollback

migrate-refresh:
	php artisan migrate:refresh

seed:
	php artisan db:seed

fresh:
	php artisan migrate:fresh --seed

test:
	php artisan test

lint:
	find app -name "*.php" -exec php -l {} \;

format:
	vendor/bin/php-cs-fixer fix app --rules=@PSR12

clear-cache:
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear

clean:
	rm -rf storage/logs/*
	rm -rf bootstrap/cache/*
	rm -rf storage/app/*

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-logs:
	docker-compose logs -f app

docker-shell:
	docker-compose exec app bash

docker-migrate:
	docker-compose exec app php artisan migrate

docker-seed:
	docker-compose exec app php artisan db:seed
