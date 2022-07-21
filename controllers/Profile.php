<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/controllers/controller.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/social-auths.php");

class ProfileController extends Controller
{

    public $login_required = true;

    public function get()
    {
        $user_id = $_SESSION["user_id"];
        return User::execute_sql("SELECT * FROM user WHERE id = :id", ["id" => $user_id], true)[0];
    }

    public function post()
    {
    }
}

$context = new ProfileController();
$context = $context->getContext();
