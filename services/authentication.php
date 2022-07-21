<?php


require_once($_SERVER["DOCUMENT_ROOT"] . "/services/authentication.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/utilities.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/config.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/services/social-auths.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");


class SignupService
{


    public function __construct($post_data = [])
    {
        if (!array_key_exists("first_name", $post_data) || $post_data["first_name"] == "") {
            return return_error_response("first_name", "First Name is Required.");
        } else if (!array_key_exists("last_name", $post_data) || $post_data["last_name"] == "") {
            return return_error_response("last_name", "Last Name is Required.");
        } else if (!array_key_exists("username", $post_data) || $post_data["username"] == "") {
            return return_error_response("username", "Username is Required.");
        } else if (!array_key_exists("password", $post_data) || $post_data["password"] == "") {
            return return_error_response("password", "Password is Required.");
        } else {
            $this->post_data = $post_data;
        }
    }

    public function create_new_user()
    {

        $user_exists = User::execute_sql("SELECT * FROM user WHERE username = :username", ["username" => $this->post_data['username']], true);

        if (isset($this->post_data["linked-in-id"])) {
            $linked_in_id_exists  = checkSocialLoginId("linked_in_id", $this->post_data["linked-in-id"]);
            if ($linked_in_id_exists) {
                return return_error_response("LinkedIn Account Already Exists", "LinkedIn Account is already taken.", ERROR_CODE::$ALREADY_EXISTS);
            }
        }

        if (!count($user_exists)) {
            $user = User::create(
                $this->post_data["first_name"],
                $this->post_data["last_name"],
                $this->post_data["username"],
                "",
                $this->post_data["password"],
                $this->post_data["linked-in-id"],
                $this->post_data["microsoft-id"]
            );

            if ($user) {
                return return_success_response("Account Created", "Your account was successfully created.", ["id" => $user]);
            } else {
                return return_error_response("Error", "An error occured.", ERROR_CODE::$DATABASE_ERROR);
            }
        } else {
            return return_error_response("Username Already Exists", "Username is already taken.", ERROR_CODE::$ALREADY_EXISTS);
        }
    }
}

class LoginService
{

    public function __construct($post_data = [])
    {
        if (!array_key_exists("username", $post_data) || $post_data["username"] == "") {
            return return_error_response("username", "Username is Required.");
        } else if (!array_key_exists("password", $post_data) || $post_data["password"] == "") {
            return return_error_response("password", "Password is Required.");
        } else {
            $this->post_data = $post_data;
        }
    }

    public function login()
    {
        $user_exists = User::execute_sql("SELECT * FROM user WHERE username = :username", ["username" => $this->post_data['username']], true);
        if (!count($user_exists)) {
            return return_error_response("Invalid Account", "Username or Password is Invalid", ERROR_CODE::$INVALID_ACCOUNT);
        } else {
            $user = $user_exists[0];
            if (password_verify($this->post_data['password'], $user["password"])) {
                $_SESSION["logged_in"] = true;
                $_SESSION["user_id"] = $user["id"];
                return return_success_response("Account Logged In", "Your account was logged in.", ["id" => $user]);
            } else {
                return return_error_response("Invalid Account", "Username or Password is Invalid", ERROR_CODE::$INVALID_ACCOUNT);
            }
        }
    }


    public static function microsoft_login($json_data = [])
    {
        $user = checkSocialLoginId("microsoft_id", $json_data["microsoft-id"]);
        if ($user != 0) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $user;
            return return_success_response("Logged In", "account logged in", ["redirect" => "/views/home/"]);
        } else {
            // use success response because token auth is mainly done on client side
            return return_success_response(
                "Invalid Account",
                "Your microsoft account is invalid",
                ["redirect" => "/views/?using=microsoft&error=" . ERROR_CODE::$INVALID_ACCOUNT]
            );
        }
    }

    public static function linked_in_login()
    {

        // direct redirection is implemented because Authentication is done on back-end.

        $social_auth = $_GET["using"];
        if ($social_auth === "linked-in") {
            $details = LinkedInSocialLogin::getDetails(false);
            $user = checkSocialLoginId("linked_in_id", $details["id"]);
            if ($user != 0) {
                $_SESSION["logged_in"] = true;
                $_SESSION["user_id"] = $user;
                header("Location: /views/home");
            } else {
                header("Location: /views/?using=linked-in&error=" . ERROR_CODE::$INVALID_ACCOUNT);
            }
        } else {
            return [];
        }
    }
}
