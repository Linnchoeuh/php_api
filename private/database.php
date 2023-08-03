<?php

require_once "db-config.php";

/**
 * This class is made for make exchange with database easier
 * by passing parameters in methods instead of direct mysql request.
 */
class DatabaseAccess
{
    private $_PDO;

    public function __construct(string $db_dsn = DB_DSN, string $db_user = DB_USER, string $db_pass = DB_PASS)
    {
        $this->initConnection($db_dsn, $db_user, $db_pass);
    }
    public function __destruct()
    {
    }



    public function initConnection(string $db_dsn = DB_DSN, string $db_user = DB_USER, string $db_pass = DB_PASS)
    {
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true,
        ];
        $this->_PDO = new PDO($db_dsn, $db_user, $db_pass, $options);
    }
    public function searchUserByEmail(string $email): Array
    {
        $request_string = "SELECT * FROM users WHERE email = :email";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":email", $email);
        $request->execute();
        while ($data = $request->fetch(PDO::FETCH_ASSOC)) {
            $request->closeCursor();
            return ($data);
        }
        $request->closeCursor();
        return ([]);
    }
    function searchUserById(int $user_id): Array
    {
        $request_string = "SELECT * FROM users WHERE user_id = :user_id";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":user_id", $user_id);
        $request->execute();
        while ($re = $request->fetch(PDO::FETCH_ASSOC)) {
            $request->closeCursor();
            return ($re);
        }
        $request->closeCursor();
        return ([]);
    }
    function addUser(string $email, string $pass): bool
    {
        $pass = md5($email.$pass);
        $request_string = "INSERT INTO users(email,pass) VALUES(:email, :pass)";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":email", $email);
        $request->bindParam(":pass", $pass);
        $request->execute();
        return (($request) ? true : false);
    }
    function searchToken(string $token): Array
    {
        return ([]);
    }
}
