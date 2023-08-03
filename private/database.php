<?php

require_once "db-config.php";

function db_init_connection(): PDO
{
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => true,
    ];
    return (new PDO(DB_DSN, DB_USER, DB_PASS, $options));
}

function search_user_by_email(PDO $PDO, string $email): Array
{
    $request = $PDO->prepare("SELECT * FROM users WHERE email = :email");
    $request->bindParam(":email", $email);
    $request->execute();
    while ($re = $request->fetch(PDO::FETCH_ASSOC)) {
        $request->closeCursor();
        return ($re);
    }
    $request->closeCursor();
    return ([]);
}

function search_user_by_id(PDO $PDO, int $user_id): Array
{
    $request = $PDO->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $request->bindParam(":user_id", $user_id);
    $request->execute();
    while ($re = $request->fetch(PDO::FETCH_ASSOC)) {
        $request->closeCursor();
        return ($re);
    }
    $request->closeCursor();
    return ([]);
}

function add_user(PDO $PDO, string $email, string $pass): bool
{
    $pass = md5($email.$pass);
    $request = $PDO->prepare("INSERT INTO users(email,pass) VALUES(:email, :pass)");
    $request->bindParam(":email", $email);
    $request->bindParam(":pass", $pass);
    $request->execute();
    return (($request) ? true : false);
}

function search_token(PDO $PDO, string $token): Array
{
}
