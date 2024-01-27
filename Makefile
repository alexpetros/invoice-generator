DB_NAME=invoices.db

.PHONY: all
all: $(DB_NAME)
	@[[ -f "$(DB_NAME)" ]] || { echo 'Missing db; run `make db`' && exit 1; }
	php -S localhost:8000 -t public lib/router.php

$(DB_NAME):
	sqlite3 $(DB_NAME) < schema.sql

.PHONY: delete-db
delete-db:
	rm -f $(DB_NAME)

.PHONY: reset-db
reset-db: delete-db $(DB_NAME)

