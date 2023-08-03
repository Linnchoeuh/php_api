<?php

define("INVALID_PARAM", "Invalid parameters.");
define("DB_FAIL", "Failed to recover data from database.");
define("INVALID_TOKEN", "Invalid token. Use login API call to get one.");

// Response codes
define("RESP_OK", 200); // request accepted, response contains result
define("RESP_CREATED", 201); // resource was created
define("RESP_NO_CONTENT", 204); // request accepted, nothing to return
define("RESP_BAD_REQUEST", 400); // Invalid request
define("RESP_NOT_FOUND", 404); // no such resource
define("RESP_NOT_ALLOWED", 405); // method cannot be performed against the resource

function send_response(string | Array $data, int $http_code = RESP_OK) : void
{
    header('Content-type: application/json');
    http_response_code($http_code);
    if (gettype($data) === "array") {
        $data = json_encode($data);
    }
    echo $data;
}
