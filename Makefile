.ONESHELL:
export SHELL := /bin/bash
export SHELLOPTS := $(if $(SHELLOPTS),$(SHELLOPTS):)errexit:pipefail
export DOCKER_BUILDKIT=1
export COMPOSE_DOCKER_CLI_BUILD=1

clean:
	docker-compose -p gestor_application down --rmi local --volumes

setup-local:
	docker-compose -p gestor_application up --build -d && \
	docker exec -it gestor_application php artisan cache:clear && \
				 	php artissssssssssssssan view:clear && \
				 	php artisan route:clear && \
				 	php artisan config:clear && \
				 	php artisan key:generate && \
				 	php artisan storage:link && \
					php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider" && \
					php artisan l5-swagger:generate && \
					php artisan jwt:secret --always-no && \
				 	composer install
local-serve:
	docker-compose -p gestor_application up

populate-db:
	docker exec -it gestor_application php artisan migrate --seed

php-md:
	docker exec -it gestor_application vendor/bin/phpmd ./app text codesize,unusedcode,naming && \
                                       vendor/bin/phpmd ./database text codesize,unusedcode,naming && \
                                       vendor/bin/phpmd ./routes text codesize,unusedcode,naming && \
                                       vendor/bin/phpmd ./tests text codesize,unusedcode,naming

php-stan:
	docker exec -it gestor_application vendor/bin/phpstan analyse app tests && \
                                       vendor/bin/phpstan analyse database tests && \
                                       vendor/bin/phpstan analyse routes tests && \
                                       vendor/bin/phpstan tests app tests

php-cs-fixer:
	docker exec -it gestor_application vendor/bin/php-cs-fixer fix app && \
						               vendor/bin/php-cs-fixer fix database && \
						               vendor/bin/php-cs-fixer fix routes && \
						               vendor/bin/php-cs-fixer fix tests

run-tests:
	  docker exec -it gestor_application php vendor/bin/codecept clean && \
                                             vendor/bin/codecept build && \
                                             vendor/bin/codecept run

define UnitTest
	docker exec -it gestor_application vendor/bin/codecept generate:cest unit $(testName)
endef

define ApiTest
	docker exec -it gestor_application vendor/bin/codecept generate:cest api $(testName)
endef

create-unit-test:
	$(call UnitTest, $(testName))

create-api-test:
	$(call ApiTest, $(testName))

