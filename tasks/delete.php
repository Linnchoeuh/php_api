<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
];

check_parameters_exist($response_json, ["token", "task_id"]);

try {
    $db = new DatabaseAccess();
    $task_id = (int)$_GET["task_id"];

    check_token($db, $_GET["token"]);
    $task = $db->findTask($task_id);
    if ($task === []) {
        $response_json["status"] = "Task not found";
        send_response($response_json, RESP_NOT_FOUND);
        exit;
    }
    if (!$db->deleteTask($task_id)) {
        $response_json["status"] = "Task deletion failed";
        send_response($response_json, RESP_INTERNAL_ERROR);
        exit;
    }
} catch (PDOException $pe) {
    send_db_error_response($response_json, $pe);
}

$response_json["status"] = "Task ".$task["task_id"]." has successfully deleted.";
send_response($response_json, RESP_OK);
