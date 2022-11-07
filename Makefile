start:
	docker-compose -f docker-compose.yml up -d --build
	sleep 3s
	php bin/console doctrine:database:create
	php bin/console make:migration
	php bin/console doctrine:migrations:migrate
	symfony server:start

