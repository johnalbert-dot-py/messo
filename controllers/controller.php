<?php

class LoginRequired
{
    public function __construct()
    {
        if (!isset($_SESSION["logged_in"])) {
            if (!$_SESSION["logged_in"]) {
                return header("Location: /views/");
            }
        }
    }
}

class Controller
{

    public $login_required = false;

    public function get()
    {
    }

    public function post()
    {
    }

    public function delete()
    {
    }

    public function put()
    {
    }

    public function __construct()
    {
        if ($this->login_required) {
            new LoginRequired();
        }
    }

    public function getContext()
    {
        $request_method = $_SERVER["REQUEST_METHOD"];

        switch ($request_method) {
            case "GET":
                return $this->get();
                break;
            case "POST":
                return $this->post();
                break;
            case "PUT":
                return $this->put();
                break;
            case "DELETE":
                return $this->delete();
                break;
        }
    }
}
