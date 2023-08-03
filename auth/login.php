<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
    "token" => "",
];

if (!is_parameters_exist(["email", "pass"])) {
    send_response($response_json, RESP_BAD_REQUEST);
    exit;
}

if (!is_email($_GET["email"])) {
    $response_json["status"] = "Invalid email";
    send_response($response_json, RESP_BAD_REQUEST);
    exit;
}

try {
    $db = new DatabaseAccess();
    $response_json["status"] = "Unknown email / password pair";
    $user = $db->searchUserByEmail($_GET["email"]);
    // print_r($user);
    if ($user === [] || $user["pass"] !== md5($_GET["email"].$_GET["pass"])) {
        send_response($response_json, RESP_BAD_REQUEST);
        exit;
    }
    $response_json["token"] = $db->createToken($user["user_id"]);
    // $db->addUser($_GET["email"], $_GET["pass"]);
} catch (PDOException $pe) {
    $response_json["status"] = $pe->getMessage();
    $response_json["token"] = "";
    send_response($response_json, RESP_OK);
    exit;
}
$response_json["status"] = "Successfully connected";
send_response($response_json, RESP_CREATED);
