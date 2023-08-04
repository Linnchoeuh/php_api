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
        try {
            if (!defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                throw new Exception("PDO extension is not correctly loaded.");
            }
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
            ];
            $this->_PDO = new PDO($db_dsn, $db_user, $db_pass, $options);
        } catch (Exception $e) {
            send_db_error_response([], $e);
        }
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
    public function searchUserById(int $user_id): Array
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
    public function addUser(string $email, string $pass): bool
    {
        $pass = md5($email.$pass);
        $request_string = "INSERT INTO users(email,pass) VALUES(:email, :pass)";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":email", $email);
        $request->bindParam(":pass", $pass);
        $request->execute();
        return (($request) ? true : false);
    }
    public function listUser(): Array
    {
        $user_list = [];
        $request_string = "SELECT email FROM users";
        $request = $this->_PDO->prepare($request_string);
        $request->execute();
        $data = $request->fetchAll(PDO::FETCH_ASSOC);
        $request->closeCursor();
        foreach ($data as $email) {
            array_push($user_list, $email["email"]);
        }
        return ($user_list);
    }
    public function createTask(string $topic, string $description): bool
    {
        $request_string = "INSERT INTO tasks(topic, description)
        VALUES(:topic, :description)";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":topic", $topic);
        $request->bindParam(":description", $description);
        $request->execute();
        return (($request) ? true : false);
    }
    public function listTask(): Array
    {
        $task_list = [];
        $request_string = "SELECT * FROM tasks";
        $request = $this->_PDO->prepare($request_string);
        $request->execute();
        $task_list = $request->fetchAll(PDO::FETCH_ASSOC);
        $request->closeCursor();
        // foreach ($data as $email) {
        //     array_push($task_list, $email["email"]);
        // }
        return ($task_list);
    }
    public function createToken(int $user_id): string
    {
        $token = md5(rand());
        $creation_date = date("Y-m-d H:i:s");
        $request_string = "INSERT INTO connection_tokens(token, creation_date, user_id)
        VALUES(:token, :creation_date, :user_id)";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":token", $token);
        $request->bindParam(":creation_date", $creation_date);
        $request->bindParam(":user_id", $user_id);
        $request->execute();
        return ($token);
    }
    public function searchToken(string $token)
    {
        $token_data = [];
        $request_string = "SELECT * FROM connection_tokens WHERE token = :token";
        $request = $this->_PDO->prepare($request_string);
        $request->bindParam(":token", $token);
        $request->execute();
        $token_data = $request->fetchAll(PDO::FETCH_ASSOC);
        $request->closeCursor();
        if (!isset($token_data[0]))
            return ([]);
        $token_data = $token_data[0];
        $token_data["creation_date"] = strtotime($token_data["creation_date"]);
        if ($token_data["creation_date"] + TOKEN_VALIDITY < time()) {
            $request_string = "DELETE FROM `connection_tokens` WHERE `token` = :token";
            $request = $this->_PDO->prepare($request_string);
            $request->bindParam(":token", $token);
            $request->execute();
            $request->closeCursor();
            return ([]);
        }
        return ($token_data);
    }
}
