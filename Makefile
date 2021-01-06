# Laradock name
LARADOCK=laradock

# Default container name version
DEFAULT_CONTAINER_VERSION=_1

# Your containers name
PHP_CONTAINER_NAME=$(LARADOCK)_php-fpm$(DEFAULT_CONTAINER_VERSION)
DB_CONTAINER_NAME=$(LARADOCK)_mysql$(DEFAULT_CONTAINER_VERSION)
PHPMYADMIN_CONTAINER_NAME=$(LARADOCK)_phpmyadmin$(DEFAULT_CONTAINER_VERSION)
BEANSTALKD_CONTAINER_NAME=$(LARADOCK)_beanstalkd$(DEFAULT_CONTAINER_VERSION)
WORKSPACE_CONTAINER_NAME=$(LARADOCK)_workspace$(DEFAULT_CONTAINER_VERSION)
REDIS_CONTAINER_NAME=$(LARADOCK)_redis$(DEFAULT_CONTAINER_VERSION)
HORIZON_CONTAINER_NAME=$(LARADOCK)_laravel-horizon$(DEFAULT_CONTAINER_VERSION)
PORTAINER_CONTAINER_NAME=$(LARADOCK)_portainer$(DEFAULT_CONTAINER_VERSION)
NODE_IMAGE_NAME=node

# MySQL environment variables
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret

# Current date
CURRENT_DATE=$(shell date +'%Y-%m-%d')

# Your list of containers to run
LIST_OF_CONTAINERS_TO_RUN=nginx mysql redis workspace

# The Laradock default repository
LARADOCK_REPOSITORY=https://github.com/laradock/laradock.git

# Verify if has a default container to run
.PHONY: nop
nop:
	@echo "Please pass a target you want to run"

# Clone the repository
.PHONY: install-laradock
install-laradock:
	git clone $(LARADOCK_REPOSITORY) $(LARADOCK) && \
	cp $(LARADOCK)/env-example $(LARADOCK)/.env && \
	sed -i "/DATA_PATH_HOST=.*/c\DATA_PATH_HOST=..\/docker-data" $(LARADOCK)/.env && \
	(test -s .env || cp .env.example .env) ; \
	sed -i "/DB_CONNECTION=.*/c\DB_CONNECTION=mysql" .env && \
	sed -i "/DB_HOST=.*/c\DB_HOST=mysql" .env && \
	sed -i "/DB_DATABASE=.*/c\DB_DATABASE=$(DB_DATABASE)" .env && \
	sed -i "/DB_USERNAME=.*/c\DB_USERNAME=$(DB_USERNAME)" .env && \
	sed -i "/DB_PASSWORD=.*/c\DB_PASSWORD=$(DB_PASSWORD)" .env && \
	sed -i "/REDIS_HOST=.*/c\REDIS_HOST=redis" .env && \
	chmod -R 777 storage

# Run initial scripts
.PHONY: initial-build
initial-build:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) composer install
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan key:generate'
	docker exec -it $(DB_CONTAINER_NAME) mysql -u root -proot -e "ALTER USER '$(DB_USERNAME)' IDENTIFIED WITH mysql_native_password BY '$(DB_PASSWORD)';";
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan migrate --seed"
	docker exec -it $(WORKSPACE_CONTAINER_NAME) npm install

# Run all containers
.PHONY: up
up:
	cd $(LARADOCK) && docker-compose up -d $(LIST_OF_CONTAINERS_TO_RUN)

# Stop all containers
.PHONY: down
down:
	cd $(LARADOCK) && docker-compose down

# Show Laravel's log in realtime
.PHONY: log
log:
	tail -f storage/logs/laravel-$(CURRENT_DATE).log

# Show docker log
.PHONY: docker-log
docker-log:
	cd $(LARADOCK) && docker-compose logs -f

# JOIN containers targets
.PHONY: join-workspace
join-workspace:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) bash

.PHONY: join-php
join-php:
	docker exec -it $(PHP_CONTAINER_NAME) bash

.PHONY: join-db
join-db:
	docker exec -it $(DB_CONTAINER_NAME) mysql -u default -p default

# Javascript related targets
.PHONY: build-js
build-js:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) npm run-script dev

.PHONY: build-js-production
build-js-production:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) npm run production --silent
.PHONY:  npm-install
npm-install:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) npm install

.PHONY: watch-js
watch-js:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) npm run-script watch-poll

# Queue related targets
.PHONY: queue-flush
queue-flush:
	docker exec -it $(REDIS_CONTAINER_NAME) redis-cli flushall

.PHONY: horizon
horizon:
	docker exec -it $(REDIS_CONTAINER_NAME) redis-cli flushall
	docker exec -it $(WORKSPACE_CONTAINER_NAME) bash -c 'php artisan horizon'

# Some artisan helpers
.PHONY: key-genrate
key-generate:
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan key:generate'

.PHONY: new-migration
new-migration:
	@read -p "Migration name: " migrationname; \
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan make:migration $$migrationname";

.PHONY: run-migrations
run-migrations:
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan migrate"

.PHONY: run-seeders
run-seeders:
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan db:seed'

.PHONY: new
new:
	@read -p "Make command and name (e.g. event TestEvent): " commandname;\
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan make:$$commandname";

# Run tests with php unit
.PHONY: test
test:
	docker exec -it $(PHP_CONTAINER_NAME) ./vendor/bin/phpunit

# Install composer dependencies
.PHONY: composer-install
composer-install:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) composer install

# Run ngrok to expose nginx webserver on port 80
.PHONY: up-ngrok
up-ngrok:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) ngrok http http://nginx:80