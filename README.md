# Laragen

This simple cli app bashed out in an afternoon takes a MySQL table as input and generates a Laravel migration from it. I think similar things probably exist but sometimes it's just easier to make it yourself.

## Usage
Run the `run.php` script from the command line:

```
php run.php tableName
``` 

## Setup
Ensure `migrations` is writable:
```
chmod +w migrations
```

Ensure your `.env` file is in the same directory with the following set:

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mydatabase
DB_USERNAME=myusername
DB_PASSWORD=mypassword


# Only supports mysql; this is implicit
DB_CONNECTION=mysql
```
