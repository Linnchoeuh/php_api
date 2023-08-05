<?php

define("DB_NAME", "php_api"); // Do not modify dbname variable unless you changed the databse name.
define("DB_DSN", "mysql:host=localhost;dbname=".DB_NAME);
define("DB_USER", "root");
define("DB_PASS", "");

define("TOKEN_VALIDITY", 86400); // Set in second the time a created token can be used before expire.
// 86400 (24h)
