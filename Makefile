start:
	docker-compose up -d

setup:
	mkdir data
	chmod 755 data
	docker-compose up -d
	sleep 15
	docker exec tecnofit-application php artisan db:seed

shell:
	docker exec -it tecnofit-application bash