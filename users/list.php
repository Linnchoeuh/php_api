<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
    "user_list" => [],
];

if (!is_parameters_exist(["token"])) {
    send_response($response_json, RESP_BAD_REQUEST);
    exit;
}

try {
    $db = new DatabaseAccess();

    if ($db->searchToken($_GET["token"]) === []) {
        $response_json["status"] = INVALID_TOKEN;
        send_response($response_json, RESP_NOT_ALLOWED);
        exit;
    }
    $response_json["user_list"] = $db->listUser();
} catch (PDOException $pe) {
    $response_json["status"] = $pe->getMessage();
    $response_json["user_list"] = [];
    send_response($response_json, RESP_OK);
    exit;
}
$response_json["status"] = "ok";
send_response($response_json, RESP_OK);
