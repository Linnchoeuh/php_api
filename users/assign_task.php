<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
];

check_parameters_exist($response_json, ["token", ["user_id", "email"], "task_id"]);

try {
    $db = new DatabaseAccess();
    $task_id = (int)$_GET["task_id"];

    check_token($db, $_GET["token"]);
    $task = $db->findTask($task_id);
    $user = get_user_from_param($db, $response_json);
    if ($task === []) {
        $response_json["status"] = "Task not found";
        send_response($response_json, RESP_NOT_FOUND);
        exit;
    }
    if (!$db->assignTask($user["user_id"], $task["task_id"])) {
        $response_json["status"] = "Failed to unassign ".$user["email"]." to task ".$task["task_id"];
        send_response($response_json, RESP_INTERNAL_ERROR);
        exit;
    }
} catch (PDOException $pe) {
    send_db_error_response($response_json, $pe);
}

$response_json["status"] = $user["email"]." has been assigned to task ".$task["task_id"].".";
send_response($response_json, RESP_OK);
