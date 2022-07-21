<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/controllers/controller.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

class HomeController extends Controller
{

    public $login_required = true;

    public function get()
    {
    }

    public function post()
    {
    }
}

$context = new HomeController();
$context = $context->getContext();
