<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/controllers/controller.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/authentication.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/social-auths.php");

class LogInController extends Controller
{

    public function get()
    {

        if (isset($_GET["error"])) {
            if ($_GET["error"] == ERROR_CODE::$INVALID_ACCOUNT) {
                if (isset($_GET["using"]) && $_GET["using"] == "linked-in") {
                    return ["error" => "Your LinkedIn account is not registered to our database."];
                } else if (isset($_GET["using"]) && $_GET["using"] == "microsoft") {
                    return ["error" => "Your Microsoft account is not registered to our database."];
                } else if (isset($_GET["using"]) && $_GET["using"] == "google") {
                    return ["error" => "Your Google account is not registered to our database."];
                } else if (isset($_GET["using"]) && $_GET["using"] == "facebook") {
                    return ["error" => "Your Facebook account is not registered to our database."];
                }
            }
        }

        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
            header("Location: /views/home/");
            die();
        } else {
            $details = ["first_name" => "", "last_name" => ""];
            if (isset($_GET["using"])) {
                if ($_GET["using"] === "linked-in") {
                    return LoginService::linked_in_login();
                } else if ($_GET["using"] === "google") {
                    return LoginService::google_login();
                } else if ($_GET["using"] === "facebook") {
                    return LoginService::facebook_login();
                }
            } else {
                return [];
            }
        }
    }

    public function post()
    {
        $json_data = json_decode(file_get_contents('php://input'), true); // use json data for POST requests
        if (isset($json_data["microsoft-id"])) {
            echo LoginService::microsoft_login($json_data);
            exit();
        } else {
            $log_in = new LoginService($_POST);
            echo $log_in->login();
            exit();
        }
    }
}

$context = new LogInController();
$context = $context->getContext();
