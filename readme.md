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

# API Call
Here are listed all the available call for this API.

## Authentication

### [POST] Register
**url:** `{{api_url}}/auth/register`

Let you register a user into the API.

**Parameters:**
- **email** *This will be the email used for [login](#[POST]-Login)*
- **pass** *The password of this user*

**Format:**
```json
{
  "status" : "Successfully registered"
}
```
**HTTP code on success:** 201



### [POST] Login
**url:** `{{api_url}}/auth/register`

Let you connect into the API. And returns you a **token** needed for all the other call.

**Parameters:**
- **email**
- **pass**

**Format:**
```json
{
  "status" : "Successfully connected",
  "token" : "abcdefghijklmnopqrstuvwxyz012345"
}
```
**HTTP code on success:** 200






## Users

### [GET] list
url: `{{api_url}}/users/list`

Let you see all the registered users and their **user_id**.

Parameters:
- **token** *obtainable with [login](#[POST]-Login) call*

**Format:**
```json
{
    "status": "ok",
    "user_list": [
        {
            "user_id": 1,
            "email": "example.user1@mail.com"
        },
        {
            "user_id": 2,
            "email": "example.user2@gmail.com"
        }
    ]
}
```
**HTTP code on success:** 200



### [GET] user
url: `{{api_url}}/users/user`

Let you see detailed information about a user.

Parameters:
- **token** *obtainable with [login](#[POST]-Login) call*

**Format:**
```json
{
    "status": "ok",
    "user_data": {
        "user_id": 1,
        "email": "example.user1@mail.com",
        "assignments": [
            {
                "task_id": 1,
                "topic": "Example 1",
                "description": "Here's a description"
            },
            {
                "task_id": 2,
                "topic": "Example 2",
                "description": "Here's a description"
            }
        ]
    }
}
```
**HTTP code on success:** 200
