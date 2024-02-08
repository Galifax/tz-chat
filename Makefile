build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

clean: composer env key optimize fresh npm-i npm-build

composer:
	docker-compose exec app sh -c "composer install && composer update"

env:
	docker-compose exec app sh -c "cp .env.example .env"

key:
	docker-compose exec app sh -c "php artisan key:generate"

optimize:
	docker-compose exec app sh -c "php artisan config:clear && php artisan cache:clear && php artisan view:clear"

fresh:
	docker-compose exec app sh -c "php artisan migrate:fresh && php artisan db:seed"

npm-i:
	docker-compose exec app sh -c "npm i"

npm-dev:
	docker-compose exec app sh -c "npm run dev"

npm-build:
	docker-compose exec app sh -c "npm run build"

test:
	docker-compose exec app sh -c "php artisan test"