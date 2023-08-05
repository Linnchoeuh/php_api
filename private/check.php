<?php

use JetBrains\PhpStorm\ArrayShape;

/**
 * @param array $get You must put in the $_GET variable
 * @param array $params An array of string parameter
 *
 * @return bool true if all the parameters exist false otherwise
 */
function check_parameters_exist(array $response_json, array $params)
{
    $one_or_param = false;
    $missing_params = [];
    foreach ($params as $param) {
        if (gettype($param) === "array") {
            $one_or_param = false;
            foreach ($param as $or_param) {
                if (isset($_GET[$or_param]))
                    $one_or_param = true;
            }
            if (!$one_or_param)
                array_push($missing_params, $param[0]);
        } else if (!isset($_GET[$param]))
            array_push($missing_params, $param);
    }
    if ($missing_params !== []) {
        if (count($missing_params) == 1) {
            $response_json["status"] = "Parameter: [".$missing_params[0]."] is missing.";
        } else {
            $response_json["status"] = "Parameters: ";
            foreach ($missing_params as $param) {
                $response_json["status"] .= "[".$param."] ";
            }
            $response_json["status"] .= "are missing.";
        }
        send_response($response_json, RESP_BAD_REQUEST);
        exit;
    }
}

function check_token(DatabaseAccess $db, string $token): Array
{
    $token_data = $db->searchToken($token);
    if ($token_data === []) {
        $response_json["status"] = INVALID_TOKEN;
        send_response($response_json, RESP_NOT_ALLOWED);
        exit;
    }
    return ($token_data);
}

/**
 * Check if it looks an email but not if this email exist.
 *
 * @param string $email
 *
 * @return bool True if it's an email false if not.
 */
function is_email(string $email): bool
{
    return (preg_match("/.+@.+\\..+/", $email) === 1);
}

function get_user_from_param(DatabaseAccess $db, Array $response_json, bool $remove_pass = true, bool $block_user_id = false): Array
{
    if (!$block_user_id && isset($_GET["user_id"])) {
        $user_id = (int)$_GET["user_id"];
        $user = $db->searchUserById($user_id);
    } else
        $user = $db->searchUserByEmail($_GET["email"]);
    if ($user === []) {
        $response_json["status"] = "User not found";
        send_response($response_json, RESP_NOT_FOUND);
        exit;
    }
    unset($user["pass"]);
    return ($user);
}
