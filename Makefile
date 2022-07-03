uid = $(shell id -u)
gid = $(shell id -g)
dc := docker-compose
exec := $(dc) exec
webexec := $(exec) --user www-data
rwebexec := $(exec) --user root

status:
	$(dc) ps

up:
	$(dc) up -d

build:
	$(dc) build --pull

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

