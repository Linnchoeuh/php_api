<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
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

if (strlen($_GET["pass"]) <= 0) {
    $response_json["status"] = "Password can't be empty";
    send_response($response_json, RESP_BAD_REQUEST);
    exit;
}

try {
    $db = new DatabaseAccess();
    if ($db->searchUserByEmail($_GET["email"]) !== []) {
        $response_json["status"] = "Email already registered use login API call";
        send_response($response_json, RESP_BAD_REQUEST);
        exit();
    }
    $db->addUser($_GET["email"], $_GET["pass"]);
} catch (PDOException $pe) {
    $response_json["status"] = $pe->getMessage();
    send_response($response_json, RESP_OK);
    exit;
}
$response_json["status"] = "Successfully registered";
send_response($response_json, RESP_CREATED);
