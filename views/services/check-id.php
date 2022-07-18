<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/services/social-auths.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/utilities.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/config.php");

$request = $_SERVER["REQUEST_METHOD"];

if ($request == "POST") {
    $post_data = json_decode(file_get_contents('php://input'), true); // use json data for POST requests
    if (isset($post_data["microsoft-id"])) {
        $microsoft_id_exists = checkSocialLoginId("microsoft_id", $post_data["microsoft-id"]);
        if ($microsoft_id_exists) {
            return return_success_response("Account Exists", "Microsoft Account already exists.", ["user_id" => $microsoft_id_exists]);
        } else {
            return return_error_response("No Account", "This Microsoft account is not existing on our database.", ERROR_CODE::$INVALID_ACCOUNT);
        }
    }
}
