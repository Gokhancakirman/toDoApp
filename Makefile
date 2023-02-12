install:
	$(MAKE) clear
	cp .env.example .env
	$(MAKE) build
	mkdir ./docker/mysql || true
	chmod -R 777 ./docker/mysql/ || true
	chmod -R 777 ./storage/ || true
	composer update --ignore-platform-req=ext-redis
	composer dump-autoload
	$(MAKE) up
	sleep 5
	docker exec -it application php artisan key:generate
	sleep 15
	$(MAKE) migrate
	sleep 4
	$(MAKE) providers

build:
	docker-compose up -d --build --remove-orphans

up:
	docker-compose up -d --remove-orphans

down:
	docker-compose down

bash:
	docker exec -it application sh

migrate:
	docker exec -it application php artisan migrate:fresh --seed

clear:
	$(MAKE) down
	rm -rf vendor || true
	rm -rf .env || true
	rm -rf ./docker/mysql/ || true

providers:
	docker exec -it application php artisan provider:add --name=Provider1 --url=http://www.mocky.io/v2/5d47f24c330000623fa3ebfa --parameters=id,zorluk,sure
	docker exec -it application php artisan provider:add --name=Provider2 --url=http://www.mocky.io/v2/5d47f235330000623fa3ebf7 --parameters={key},level,estimated_duration

test:
	docker exec -it application php artisan test
