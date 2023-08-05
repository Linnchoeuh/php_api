<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
];

check_parameters_exist($response_json, ["token", "topic", "description"]);

try {
    $db = new DatabaseAccess();
    check_token($db, $_GET["token"]);
    if ($_GET["topic"] === "") {
        $response_json["status"] = "Topic cannot be empty";
        send_response($response_json, RESP_NOT_ALLOWED);
        exit;
    }
    if ($_GET["description"] === "") {
        $response_json["status"] = "Description cannot be empty";
        send_response($response_json, RESP_NOT_ALLOWED);
        exit;
    }
    if (!$db->createTask($_GET["topic"], $_GET["description"])) {
        $response_json["status"] = "Task not created";
        send_response($response_json, RESP_INTERNAL_ERROR);
        exit;
    }
} catch (PDOException $pe) {
    send_db_error_response($response_json, $pe);
}
$response_json["status"] = "Task created";
send_response($response_json, RESP_CREATED);
