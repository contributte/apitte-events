.PHONY: install qa cs csf phpstan tests coverage-clover coverage-html

install:
	composer update

qa: phpstan cs

cs:
	vendor/bin/linter src

csf:
	vendor/bin/codesniffer src

phpstan:
	vendor/bin/phpstan analyse -l max -c phpstan.neon src
