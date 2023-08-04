<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
    "token" => "",
];

check_parameters_exist($response_json, ["email", "pass"]);

if (!is_email($_GET["email"])) {
    $response_json["status"] = "Invalid email";
    send_response($response_json, RESP_BAD_REQUEST);
    exit;
}

try {
    $db = new DatabaseAccess();
    $response_json["status"] = "Unknown email / password pair";
    $user = $db->searchUserByEmail($_GET["email"]);
    if ($user === [] || $user["pass"] !== md5($_GET["email"].$_GET["pass"])) {
        send_response($response_json, RESP_BAD_REQUEST);
        exit;
    }
    $response_json["token"] = $db->createToken($user["user_id"]);
} catch (PDOException $pe) {
    $response_json["token"] = "";
    send_db_error_response($response_json, $pe);
}
$response_json["status"] = "Successfully connected";
send_response($response_json, RESP_OK);
