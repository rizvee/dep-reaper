.PHONY: check test analyse build

check:
	vendor/bin/phpstan analyse
	vendor/bin/phpcs

test:
	vendor/bin/phpunit

analyse:
	php bin/dep-reaper --output=compact

build:
	vendor/bin/box compile
