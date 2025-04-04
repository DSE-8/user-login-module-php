.PHONY : main build-image build-container start test shell stop clean
main: build-image build-container

build-image:
	docker build -t user-login-module .

build-container:
	docker run -dt --name user-login-module -v .:/540/user-login-module user-login-module
	docker exec user-login-module composer install

start:
	docker start user-login-module

test: start
	docker exec user-login-module ./vendor/bin/phpunit tests/$(target)

shell: start
	docker exec -it user-login-module /bin/bash

stop:
	docker stop user-login-module

clean: stop
	docker rm user-login-module
	rm -rf vendor
