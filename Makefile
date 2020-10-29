container=php-fpm
folder=docker

build: copy-env rm up composer-install
copy-env:
	cp --no-clobber docker/.env.dist docker/.env
	cp --no-clobber .env .env.local
rm:
	cd ${folder} && docker-compose stop
	cd ${folder} && docker-compose rm -v -f
	cd ${folder} && docker-compose build
stop:
	cd ${folder} && docker-compose stop
up:
	cd ${folder} && docker-compose up -d
bash:
	cd ${folder} && docker-compose exec ${container} /bin/bash
composer-install:
	cd ${folder} && docker-compose run --rm ${container} sh -lc 'composer install'
