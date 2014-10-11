test:
	make reset
	bin/behat

reset:
	sqlite3 database/costumes.sqlite < temp/reset.sql
	sqlite3 database/costumes.sqlite < temp/install.sql
	sqlite3 database/costumes.sqlite < temp/dummydata.sql

