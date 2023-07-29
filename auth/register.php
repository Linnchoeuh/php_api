<?php

require_once "../private/api-response.php";

$reponse_json = [
    "status" => INVALID_PARAM,
];

if (!isset($_GET["email"]) || !isset($_GET["pass"])) {
    send_response($reponse_json, RESP_BAD_REQUEST);
    exit();
}

$reponse_json["status"] = "ok";
$reponse_json["token"] = md5(rand());
send_response($reponse_json, RESP_CREATED);
