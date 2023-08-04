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

    check_token($db, $_GET["token"]);
    if (!$db->findTask($_GET["task_id"])) {
        $response_json["status"] = "Task not found";
        send_response($response_json, RESP_NOT_FOUND);
        exit;
    }
    if (isset($_GET["topic"]) &&
    !$db->editTaskTopic($_GET["task_id"], $_GET["topic"])) {
        $response_json["status"] = "Failed to update topic";
        send_response($response_json, RESP_INTERNAL_ERROR);
        exit;
    }
    if (isset($_GET["description"]) &&
    !$db->editTaskDescription($_GET["task_id"], $_GET["description"])) {
        $response_json["status"] = "Failed to update description";
        send_response($response_json, RESP_INTERNAL_ERROR);
        exit;
    }
} catch (PDOException $pe) {
    send_db_error_response($response_json, $pe);
}
$response_json["status"] = "Task updated";
send_response($response_json, RESP_OK);
