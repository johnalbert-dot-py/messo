<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/model/User.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



abstract class SocialLogin
{
    public static $provider;
    public static $error;

    public static abstract function getProvider();
    public static abstract function getDetails();

    public static function getRedirectUrl($provider = "", $default = "")
    {
        $redirect_page = "";
        if (isset($_GET['redirect'])) {
            switch ($_GET['redirect']) {
                case 'sign-up':
                    $redirect_page = "http://localhost/views/sign-up-form.php?using=" . $provider;
                    break;
                case 'login':
                    $redirect_page = "http://localhost/views/?using=" . $provider;
                    break;
                default:
                    $redirect_page = $default;
                    break;
            }
        } else {
            $redirect_page = "http://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?');

            if (strpos($redirect_page, "sign-up-form.php") !== false) {
                $redirect_page = "http://localhost/views/sign-up-form.php?using=" . $provider;
            } else {
                $redirect_page = "http://localhost/views/?using=" . $provider;
            }
        }
        return $redirect_page;
    }
}

function checkSocialLoginId($social_id_name = "", $id = 0)
{
    $id_exists = User::execute_sql("SELECT * FROM user WHERE $social_id_name = :$social_id_name", ["$social_id_name" => $id], true);
    if (count($id_exists)) {
        return $id_exists[0]["id"];
    } else {
        return 0;
    }
}

class LinkedInSocialLogin extends SocialLogin
{

    public static $provider;
    public static $error;

    public static function getProvider()
    {
        $redirect_page = self::getRedirectUrl("linked-in", LinkedInConfig::$REDIRECT_URI);
        $provider = new League\OAuth2\Client\Provider\LinkedIn([
            'clientId'          => LinkedInConfig::$CLIENT_ID,
            'clientSecret'      => LinkedInConfig::$CLIENT_SECRET,
            'redirectUri'       => $redirect_page,
        ]);
        return $provider;
    }

    public static function getDetails($verify_exists = true)
    {
        $provider = self::getProvider();
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
        } catch (Exception $e) {
            if (strpos("http://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'), "sign-up-form.php") !== false) {
                header("Location: http://localhost/views/sign-up.php");
            } else {
                header("Location: http://localhost/views/");
            }
        }

        try {
            $user = $provider->getResourceOwner($token);
            $user_linkedin_id = $user->getId();

            if ($verify_exists) {
                $user_exists = checkSocialLoginId("linked_in_id", $user_linkedin_id);
                if ($user_exists) {
                    header("Location: http://localhost/views/sign-up.php?error=" . ERROR_CODE::$ALREADY_EXISTS);
                    exit();
                }
            }
            $user_data = [
                "first_name" => $user->getFirstName(),
                "last_name" => $user->getLastName(),
                "username" => strtok($user->getEmail(), '@'),
                "id" => $user_linkedin_id,
                "error" => "",
            ];
            return $user_data;
        } catch (Exception $e) {
            echo $e;
            exit('Oh dear...');
        }
    }
}


class MicrosoftSocialLogin extends SocialLogin
{
    public static $provider;
    public static function getProvider()
    {
        $redirect_page = parent::getRedirectUrl("microsoft", MicrosoftConfig::$REDIRECT_URI);
        $url = MicrosoftConfig::getLoginUrl($redirect_page);
        header("Location: " . $url);
    }

    public static function getDetails()
    {
        // implemented on client side
    }
}
