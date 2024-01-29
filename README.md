# Invoice Generator
## Description
A little PHP project to generate invoices using HTML. Using a browser-based interface, you can specify configs for particular clients and businesses, and then generate new invoices using those configs.

## Instructions
* `make` - Start the local server
* `make reset-db` - Delete local database and make a new one from scratch

## TODO
* Start new invoice by cloning the params of the last one
* Stores the generated invoices in an SQLite database
* Add a CLI interface that parses JSON invoice configs as well
