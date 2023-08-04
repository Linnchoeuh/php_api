<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
    "user_list" => [],
];


check_parameters_exist($response_json, ["token"]);

try {
    $db = new DatabaseAccess();

    check_token($db, $_GET["token"]);
    $response_json["user_list"] = $db->listUser();
} catch (PDOException $pe) {
    $response_json["user_list"] = [];
    send_db_error_response($response_json, $pe);
}
$response_json["status"] = "ok";
send_response($response_json, RESP_OK);
