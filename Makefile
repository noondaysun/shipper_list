SHELL := bash
.ONESHELL:
.SHELLFLAGS := -eu -o pipefail -c
.DELETE_ON_ERROR:
MAKEFLAGS += --warn-undefined-variables
MAKEFLAGS += --no-builtin-rules

ifeq ($(origin .RECIPEPREFIX), undefined)
  $(error This Make does not support .RECIPEPREFIX. Please use GNU Make 4.0 or later)
endif
.RECIPEPREFIX = >

.PHONY: clean shell start test

clean:
> ./vendor/bin/sail stop

shell:
> ./vendor/bin/sail shell

start:
> ./vendor/bin/sail up -d

test:
> ./vendor/bin/php-cs-fixer fix
> ./vendor/bin/rector process --ansi
> ./vendor/bin/phpstan analyse --memory-limit=2G
> ./vendor/bin/sail test