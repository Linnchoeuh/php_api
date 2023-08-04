CREATE DATABASE php_api;
USE php_api;
CREATE TABLE IF NOT EXISTS users
(
    `user_id` INT UNSIGNED AUTO_INCREMENT,
    `email` VARCHAR(64) NOT NULL,
    `pass` VARCHAR(32) NOT NULL,

	UNIQUE(`email`),
	PRIMARY KEY(`user_id`)
);

CREATE TABLE IF NOT EXISTS tasks
(
    `task_id` INT UNSIGNED AUTO_INCREMENT,
    `topic` VARCHAR(128),
    `description` VARCHAR(512),

    UNIQUE(`task_id`),
	PRIMARY KEY(`task_id`)
);

CREATE TABLE IF NOT EXISTS connection_tokens
(
    `token` VARCHAR(32),
    `creation_date` TIMESTAMP,
    `user_id` INT UNSIGNED,

    UNIQUE(`token`),
	PRIMARY KEY(`token`),
    FOREIGN KEY(`user_id`)
    REFERENCES `php_api`.`users`(`user_id`)
);

CREATE TABLE IF NOT EXISTS assignation
(
    `user_id` INT UNSIGNED NOT NULL,
    `task_id` INT UNSIGNED NOT NULL,

    FOREIGN KEY(`user_id`)
    REFERENCES `php_api`.`users`(`user_id`),
    FOREIGN KEY(`task_id`)
    REFERENCES `php_api`.`tasks`(`task_id`)
);
