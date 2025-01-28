# Dossier de tests du projet
TEST:=tests
# SYMFONY_BIN = lien vers fichier console de symfony
SYMFONY_BIN=$(PHP_BIN) ./bin/console

# composer
COMPOSER_BIN=composer

# php
PHP_BIN=php -d memory_limit=-1 $(PHP_OPTIONS)

# php-unit
#PHPUNIT_BIN=phpdbg -qrr $(PHP_OPTIONS) ./bin/phpunit $(PHPUNIT_OPTIONS)
PHPUNIT_BIN=$(PHP_BIN) ./bin/phpunit $(PHPUNIT_OPTIONS)

# php-cs-fixer
PHP_CS_FIXER_BIN=./vendor/bin/php-cs-fixer
# phpstan
PHPSTAN_BIN=$(PHP_BIN) -d memory_limit=-1 ./vendor/bin/phpstan

# twig-cs
TWIG_CS_BIN=./vendor/bin/twig-cs-fixer

# Definition environnement
ifndef APP_ENV
    export APP_ENV:=dev
endif

# Definition SUITE for phpunit
ifndef SUITE
     SUITE:=all
endif

# Definition VARIABLES FOR CI
ifdef CI
    SYMFONY_BIN+=--ansi
    PHPUNIT_OPTIONS+=--color=always
    COMPOSER_BIN+=--ansi
    PHPSTAN_BIN+=--ansi --no-progress
    PHP_CS_FIXER_BIN+=--ansi
endif

# Definition COVERAGE FOR phpUnit Coverage
ifdef COVERAGE
    ifneq ($(COVERAGE),disable)
        PHPUNIT_OPTIONS+=--coverage-html=$(COVERAGE) --coverage-text
    endif
endif

PHP_SECURITY_CHECKER=/usr/local/bin/php-security-checker

all: vendor resetdb assets cacheclear ## Initialize application for devellopement

help:
	## Show this help.
	@echo "Please use 'make <target>' where <target> is one of"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-15s\033[0m %s\n", $$1, $$2}'

cc: cacheclear ## Clear the cache
cacheclear:
	$(SYMFONY_BIN) cache:clear
	rm -f ./var/logs/$(APP_ENV).log
	$(SYMFONY_BIN) cache:warmup

resetdb: dropdb createdb fixtures ## Reset database With fixtures

createdb: ## Create database
	$(SYMFONY_BIN) doctrine:database:create
	$(SYMFONY_BIN) doctrine:schema:create

dropdb: ## Drop database
	$(SYMFONY_BIN) doctrine:database:drop --force --if-exists

.PHONY: fixtures
fixtures: ## Import Fixtures
	$(SYMFONY_BIN) doctrine:fixtures:load --no-interaction

phpunit: PHP_OPTIONS+=-dmemory_limit=-1
phpunit: ## Execute phpunit Tests
	$(PHPUNIT_BIN) -c ./phpunit.xml --testsuite ${SUITE} --verbose --stop-on-failure

test: APP_ENV:=test
test: cacheclear dropdb createdb cacheclear phpunit ## Execute the tests of the application

isotest: APP_ENV:=test ## Test an isolate file/folder
isotest: cacheclear dropdb createdb cacheclear
isotest: PHP_OPTIONS+=-dmemory_limit=-1
isotest: PHPUNIT_OPTIONS+=-c app --verbose $(TEST)
isotest:
	@echo ' '
	@echo "\033[92mLancement des tests sur"
	@dir $(TEST)
	@echo "\033[92m\033[0m"
	$(PHPUNIT_BIN)

.PHONY: assets
assets: ## Build the development version of the assets.
assets: public/build

.PHONY: assets-prod
assets-prod:    ## Build the production version of the assets.
assets-prod: node_modules
	yarn build

.PHONY: public/build
public/build: node_modules
	yarn encore dev

node_modules: yarn.lock
	yarn install

yarn.lock: package.json
	@echo yarn.lock is not up to date.

vcomposer: ## Validate Composer
	$(COMPOSER_BIN) validate

ltwig: vendor ## Lint Twig
	$(SYMFONY_BIN) lint:twig templates src

lyaml: vendor ## Lint Yaml
	$(SYMFONY_BIN) lint:yaml config
	$(SYMFONY_BIN) lint:yaml src

vschema: vendor ## Validate Schema Doctrine
	$(SYMFONY_BIN) doctrine:schema:validate --skip-sync --em=default

.PHONY: fixer
fixer: phpcsfix twigcsfix prettierfix ## Fixers

phpcs: PHP_CS_FIXER_BIN+=--dry-run
phpcs: phpcsfix

.PHONY: phpcsfix
phpcsfix: ## Fix PHP
	$(PHP_CS_FIXER_BIN) fix --format=txt --verbose --show-progress=dots

phpstan: PHP_OPTIONS+=-dmemory_limit=-1
phpstan: vendor ## Check Code
	$(PHPUNIT_BIN) --version
	$(PHPSTAN_BIN) analyse -c phpstan.neon

.PHONY: vendor
vendor: composer.lock ## Install Vendor
	$(COMPOSER_BIN) install --prefer-dist

.PHONY: composer.lock
composer.lock: composer.json
	@echo composer.lock is not up to date

.PHONY: securitychecker
securitychecker: vendor
	$(PHP_SECURITY_CHECKER)


review: vcomposer ltwig lyaml vschema phpcs phpstan securitychecker twigcs prettier## Execute all reviews for code


watch:
	yarn watch

build:
	yarn run build

trad:
	$(SYMFONY_BIN) translation:extract --force fr


.PHONY: twigcs
twigcs:
	$(TWIG_CS_BIN) lint --config=.twig-cs-fixer.php templates

.PHONY: twigcsfix
twigcsfix:
	$(TWIG_CS_BIN) lint --config=.twig-cs-fixer.php --fix templates

.PHONY: prettier
prettier:
	yarn cs

.PHONY: prettierfix
prettierfix:
	yarn csfix
