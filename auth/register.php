<?php

require_once "../private/api-response.php";
require_once "../private/database.php";

$reponse_json = [
    "status" => INVALID_PARAM,
];

if (!isset($_GET["email"]) || !isset($_GET["pass"])) {
    send_response($reponse_json, RESP_BAD_REQUEST);
    exit();
}

if (preg_match("/.+@.+\\..+/", $_GET["email"]) !== 1) {
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
    $PDO = db_init_connection();
    if (search_user_by_email($PDO, $_GET["email"]) !== []) {
        $reponse_json["status"] = "Email already registered use login API call";
        send_response($reponse_json, RESP_BAD_REQUEST);
        exit();
    }
    add_user($PDO, $_GET["email"], $_GET["pass"]);
} catch (PDOException $pe) {
    $reponse_json["status"] = $pe->getMessage();
    send_response($reponse_json, RESP_OK);
    exit();
}
$reponse_json["status"] = "Successfully registered";
// $reponse_json["token"] = md5(rand());
send_response($reponse_json, RESP_CREATED);
