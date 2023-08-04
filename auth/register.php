<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$response_json = [
    "status" => INVALID_PARAM,
];


check_parameters_exist($response_json, ["email", "pass"]);

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
        exit;
    }
    if (!$db->addUser($_GET["email"], $_GET["pass"])) {
        $response_json["status"] = "Registration failed";
        send_response($response_json, RESP_INTERNAL_ERROR);
        exit;
    }
} catch (PDOException $pe) {
    send_db_error_response($response_json, $pe);
}
$response_json["status"] = "Successfully registered";
send_response($response_json, RESP_CREATED);
