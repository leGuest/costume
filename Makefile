install:
	composer self-update
	composer install
	mkdir -p database/ cache/
	chmod -R 777 database/ cache/
	touch costumes.sqlite
	make reset

test:
	make reset
	bin/behat

reset:
	sqlite3 database/costumes.sqlite < temp/reset.sql
	sqlite3 database/costumes.sqlite < temp/install.sql
	sqlite3 database/costumes.sqlite < temp/dummydata.sql

