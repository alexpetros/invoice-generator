DB_NAME=invoices.db

.PHONY: all
all:
	php -S localhost:8000 -t public

.PHONY: reset-db
reset-db:
	rm -f $(DB_NAME)
	sqlite3 $(DB_NAME) < schema.sql
