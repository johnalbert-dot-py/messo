<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/controllers/controller.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/authentication.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/social-auths.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

class SignUpController extends Controller
{

    public function get()
    {
        $details = ["first_name" => "", "last_name" => ""];
        if (isset($_GET["using"])) {
            $social_auth = $_GET["using"];
            if ($social_auth === "linked-in") {
                $details = LinkedInSocialLogin::getDetails();
            } else if ($social_auth === "google") {
                $details = GoogleSocialLogin::getDetails();
            }
        }
        return $details;
    }

    public function post()
    {
        $sign_up = new SignupService($_POST);
        echo $sign_up->create_new_user();
        exit();
    }
}

$context = new SignUpController();
$context = $context->getContext();
