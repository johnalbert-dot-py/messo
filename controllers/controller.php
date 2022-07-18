<?php

class Controller
{

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
