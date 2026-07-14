.PHONY: help up down migrate build build-no-cache shell optimize npm-build

help:
	@echo "Docker Commands"
	@echo ""
	@echo "  make up               - Start environment"
	@echo "  make down             - Stop environment"
	@echo "  make migrate          - Run migration"
	@echo "  make optimize         - Run optimize"
	@echo "  make npm-build        - npm run build"
	@echo "  make build            - Build image"
	@echo "  make build-no-cache   - Build image without cache"
	@echo "  make shell            - Access shell"

up:
	docker compose --profile dev up -d

down:
	docker compose --profile dev down

migrate:
	docker exec herpes php artisan migrate

optimize:
	docker exec herpes php artisan optimize:clear && php artisan optimize

npm-build:
	docker exec herpes npm run build

build:
	docker compose --profile dev build

build-no-cache:
	docker compose --profile dev build --no-cache

shell:
	docker compose --profile dev exec herpes bash
