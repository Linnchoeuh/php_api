<?php

/**
 * @param array $get You must put in the $_GET variable
 * @param array $params An array of string parameter
 *
 * @return bool true if all the parameters exist false otherwise
 */
function is_parameters_exist(array $params): bool
{
    // print_r($_GET);
    foreach ($params as $param) {
        if (!isset($_GET[$param]))
            return (false);
    }
    return (true);
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
