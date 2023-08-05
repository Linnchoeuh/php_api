<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
    "user_data" => [],
];

check_parameters_exist($response_json, ["token", ["user_id", "email"]]);

try {
    $db = new DatabaseAccess();

    check_token($db, $_GET["token"]);
    $user = get_user_from_param($db, $response_json);
    $user["assignments"] = $db->findUserAssignment($user["user_id"]);

    $response_json["user_data"] = $user;
} catch (PDOException $pe) {
    send_db_error_response($response_json, $pe);
}

$response_json["status"] = "ok";
send_response($response_json, RESP_OK);
