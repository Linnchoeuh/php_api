# Apache Configuration

This code has been hosted on Apache 2.4.

You must add/uncomment the following line to your httpd.conf file:

> LoadModule rewrite_module modules/mod_rewrite.so

# PHP Configuration

This code has been developped on php 8.2.8.

You must add/edit/uncomment the following line to your php.ini file:

> extension_dir = "path/to/your/php/extension/folder"
> extension=pdo_mysql

# Database Configuration

This API use **MYSQL 8.1** as database,
you can configure your login information in `./private/db-config.php`

All the setup of the database itself is written in `./private/database.sql`

# API CALL
Here are listed all the available call for this API.

## Authentication:

### [POST] register
url: `{{api_url}}/auth/register`
Let you register a user into the API.
Parameters:
- **email** *This will be email used for [login](#[POST]-login)*
- **pass** *The password of this user*


### [POST] login
url: `{{api_url}}/auth/login`
Let you connect into the API. And returns you a **token** needed for all the other call.
Parameters:
- **email**
- **pass**
