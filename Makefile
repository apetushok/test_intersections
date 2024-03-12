install:
	docker-compose up -d
	docker-compose exec php bash -c 'composer install --no-interaction --optimize-autoloader'

tests:
	docker-compose exec php bash -c 'vendor/bin/phpunit tests'