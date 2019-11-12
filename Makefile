.PHONY: test coverage

test:
	php vendor/bin/phpunit

coverage:
	php vendor/bin/phpunit --coverage-html coverage/