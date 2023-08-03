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
