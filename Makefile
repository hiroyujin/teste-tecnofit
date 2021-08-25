start:
	docker-compose up -d

setup:
	cp .env.example .env
	docker volume create --label tecnofit_mariadb --name tecnofit_mariadb
	docker-compose up -d
	sleep 15
	docker exec tecnofit-application php artisan key:generate
	docker exec tecnofit-application php artisan db:seed

shell:
	docker exec -it tecnofit-application bash

destroy:
	docker stop tecnofit-application
	docker stop tecnofit-mariadb
	docker rm tecnofit-application
	docker rm tecnofit-mariadb
	docker volume rm tecnofit_mariadb