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
                }
            }
        }

        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
            header("Location: ./logged_in.php");
            die();
        } else {
            $details = ["first_name" => "", "last_name" => ""];
            if (isset($_GET["using"])) {
                $social_auth = $_GET["using"];
                if ($social_auth === "linked-in") {
                    $details = LinkedInSocialLogin::getDetails(false);
                    $user = checkSocialLoginId("linked_in_id", $details["id"]);
                    if ($user != 0) {
                        $_SESSION["logged_in"] = true;
                        $_SESSION["user_id"] = $user;
                        header("Location: ./logged_in.php");
                    } else {
                        header("Location: /views/?using=linked-in&error=" . ERROR_CODE::$INVALID_ACCOUNT);
                    }
                } else {
                    return [];
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
            $user = checkSocialLoginId("microsoft_id", $json_data["microsoft-id"]);
            if ($user != 0) {
                $_SESSION["logged_in"] = true;
                $_SESSION["user_id"] = $user;
                echo return_success_response("Logged In", "account logged in", ["redirect" => "/views/logged_in.php"]);
                exit();
            } else {
                echo return_success_response(
                    "Invalid Account",
                    "Your microsoft account is invalid",
                    ["redirect" => "/views/?using=microsoft&error=" . ERROR_CODE::$INVALID_ACCOUNT]
                );
                exit();
            }
        } else {
            $log_in = new LoginService($_POST);
            echo $log_in->login();
            exit();
        }
    }
}

$context = new LogInController();
$context = $context->getContext();
