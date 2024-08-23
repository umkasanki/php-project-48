# Makefile
setup:
	composer --version
	composer install
	chmod +x bin/gendiff

validate:
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src bin

#gendiff:
#	./bin/gendiff