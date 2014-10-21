install:
	rm -rf database/*
	composer self-update
	composer install
	mkdir -p database/ cache/
	chmod -R 777 database/ cache/
	make prod

test:
	make reset-dev
	bin/behat

reset-dev:
	make dev
	sqlite3 database/costumes.sqlite < temp/reset.sql
	sqlite3 database/costumes.sqlite < temp/install.sql
	sqlite3 database/costumes.sqlite < temp/dummydata.sql
	sqlite3 database/costumes.sqlite < temp/adminaccount.sql

dev:
	cat config/env_dev.php > config/env.php
	touch database/costumes.sqlite
	chmod -R 777 database/

prod:
	cat config/env_prod.php > config/env.php
	rm -rf database/costumes.sqlite
	touch database/costumes_prod.sqlite
	chmod -R 777 database/
	sqlite3 database/costumes_prod.sqlite < temp/reset.sql
	sqlite3 database/costumes_prod.sqlite < temp/install.sql
	sqlite3 database/costumes_prod.sqlite < temp/dummydata.sql
	sqlite3 database/costumes_prod.sqlite < temp/adminaccount.sql
	bin/behat
	sqlite3 database/costumes_prod.sqlite < temp/reset.sql
	sqlite3 database/costumes_prod.sqlite < temp/install.sql
	sqlite3 database/costumes_prod.sqlite < temp/adminaccount.sql
