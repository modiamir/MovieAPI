uid = $(shell id -u)
gid = $(shell id -g)
dc := docker-compose
exec := $(dc) exec
webexec := $(exec) --user www-data
rwebexec := $(exec) --user root

setup : build up

status:
	$(dc) ps

up:
	$(dc) up -d

build:
	$(dc) build --pull --build-arg UID=${uid} --build-arg GID=${gid}

stop:
	$(dc) stop

down:
	$(dc) down

restart:
	$(dc) restart

sh:
	$(webexec) php /bin/sh

rsh:
	$(rwebexec) php /bin/sh

destroy:
	$(dc) down -v --remove-orphans

migrate:
	$(webexec) php ./bin/console doctrine:migration:migrate -n

test:
	$(webexec) --env APP_ENV=test php ./bin/console doctrine:database:create --if-not-exists
	$(webexec) --env APP_ENV=test php ./bin/console doctrine:migration:migrate --no-interaction
	$(webexec) php ./bin/phpunit

