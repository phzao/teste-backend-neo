up:
	@echo '************  Criando network ************'
	@echo '*'
	@echo '*'
	docker network inspect db_network >/dev/null 2>&1 || docker network create db_network
	@echo '************  Subindo DB ************'
	@echo '*'
	@echo '*'
	docker-compose up -d

	@echo '*'
	@echo '*'
	@echo '************  Subindo Backend ************'
	@echo '*'
	@echo '*'
	cp backend/.env.example backend/.env
	chmod -R 777 backend/storage
	docker-compose -f backend/docker-compose.yml up -d

	@echo '*'
	@echo '*'
	@echo '************  Instalando lumen ************'
	@echo '*'
	@echo '*'
	docker exec api-php composer install

	@echo '*'
	@echo '*'
	@echo '************  Executando migrate ************'
	@echo '*'
	@echo '*'
	docker exec api-php php artisan migrate

	@echo '*'
	@echo '*'
	@echo '************  Subindo Frontend ************'
	@echo '*'
	@echo '*'
	docker-compose -f frontend/docker-compose.yml up -d