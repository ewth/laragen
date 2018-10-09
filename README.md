# laragen

This cli app takes a MySQL table as input and generates a Laravel migration from it.

Reads your settings from the `.env` file:

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mydatabase
DB_USERNAME=myusername
DB_PASSWORD=mypassword


# Only supports mysql; this is implicit
DB_CONNECTION=mysql
```
