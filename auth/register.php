<?php

require_once "../private/api-response.php";
require_once "../private/database.php";
require_once "../private/check.php";

$reponse_json = [
    "status" => INVALID_PARAM,
];

if (!is_parameters_exist(["email", "pass"])) {
    send_response($reponse_json, RESP_BAD_REQUEST);
    exit;
}

if (!is_email($_GET["email"])) {
    $reponse_json["status"] = "Invalid email";
    send_response($reponse_json, RESP_BAD_REQUEST);
    exit();
}

if (strlen($_GET["pass"]) <= 0) {
    $reponse_json["status"] = "Password can't be empty";
    send_response($reponse_json, RESP_BAD_REQUEST);
    exit();
}

try {
    $db = new DatabaseAccess();
    if ($db->searchUserByEmail($_GET["email"]) !== []) {
        $reponse_json["status"] = "Email already registered use login API call";
        send_response($reponse_json, RESP_BAD_REQUEST);
        exit();
    }
    $db->addUser($_GET["email"], $_GET["pass"]);
} catch (PDOException $pe) {
    $reponse_json["status"] = $pe->getMessage();
    send_response($reponse_json, RESP_OK);
    exit();
}
$reponse_json["status"] = "Successfully registered";
send_response($reponse_json, RESP_CREATED);
