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
- **email** *This will be the email used for [login](#post-login)*
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
**url:** `{{api_url}}/users/list`

Let you see all the registered users and their **user_id**.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*

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
**url:** `{{api_url}}/users/user`

Let you see detailed information about a user.

Parameters:
- **token** *Obtainable with [login](#post-login) call*

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
                "description": "Here's a description!"
            },
            {
                "task_id": 2,
                "topic": "Example 2",
                "description": "Here's a description!"
            }
        ]
    }
}
```
**HTTP code on success:** 200



### [PUT] assign_task
**url:** `{{api_url}}/users/assign_task`

Let you assign a user to a task.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*
- **user_id**/**email** *The user that will be assigned to the task*
- **task_id** *The task the user will be assign to*

**Format:**
```json
{
    "status": "example.user1@mail.com has been assigned to task 1."
}
```
**HTTP code on success:** 200



### [DELETE] unassign_task
**url:** `{{api_url}}/users/unassign_task`

Let you unassign a user from a task.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*
- **user_id**/**email** *The user that will be unassigned from the task*
- **task_id** *The task the user will be unassigned from*

**Format:**
```json
{
    "status": "example.user1@mail.com has been unassigned to task 1."
}
```
**HTTP code on success:** 200






## Tasks

### [GET] list
**url:** `{{api_url}}/tasks/list`

List all the created tasks.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*

**Format:**
```json
{
    "status": "ok",
    "task_list": [
        {
            "task_id": 1,
            "topic": "Example 1",
            "description": "Here's a description!"
        },
        {
            "task_id": 2,
            "topic": "Example 2",
            "description": "Here's a description!"
        }
    ]
}
```
**HTTP code on success:** 200



### [GET] task
**url:** `{{api_url}}/tasks/task`

Let you see detailed information about a task.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*
- **task_id**

**Format:**
```json
{
    "status": "ok",
    "task_data": {
        "task_id": 1,
        "topic": "Example 1",
        "description": "Here's a description!",
        "assignee": [
            {
                "user_id": 1,
                "email": "example.user1@mail.com"
            },
            {
                "user_id": 2,
                "email": "example.user2@mail.com"
            }
        ]
    }
}
```
**HTTP code on success:** 200



### [POST] create
**url:** `{{api_url}}/tasks/create`

Let you create task.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*
- **topic** *The topic of the task (must be filled)*
- **description** *The description of the task (must be filled)*

**Format:**
```json
{
    "status": "Task created"
}
```
**HTTP code on success:** 201



### [PUT] update
**url:** `{{api_url}}/tasks/update`

Let you edit a task topic and/or description.
You must not put the parameter (topic/description) if you don't want to edit it.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*
- **task_id**
- **topic** *The new topic of the task (optional)*
- **description** *The new description of the task (optional)*

**Format:**
```json
{
    "status": "Task updated"
}
```
**HTTP code on success:** 200



### [DELETE] delete
**url:** `{{api_url}}/tasks/delete`

Delete the task and unassign every user who were.

**Parameters:**
- **token** *Obtainable with [login](#post-login) call*
- **task_id**

**Format:**
```json
{
    "status": "Task 1 has been successfully deleted."
}
```
**HTTP code on success:** 200
