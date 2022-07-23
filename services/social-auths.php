<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/model/User.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use League\OAuth2\Client\Provider\Google;


function checkSocialLoginId($social_id_name = "", $id = 0)
{
    $id_exists = User::execute_sql("SELECT * FROM user WHERE $social_id_name = :$social_id_name", ["$social_id_name" => $id], true);
    if (count($id_exists)) {
        return $id_exists[0]["id"];
    } else {
        return 0;
    }
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


    public static function getToken($provider)
    {
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            return $token;
        } catch (Exception $e) {
            if (strpos("http://$_SERVER[HTTP_HOST]" . strtok($_SERVER["REQUEST_URI"], '?'), "sign-up-form.php") !== false) {
                header("Location: http://localhost/views/sign-up.php");
            } else {
                header("Location: http://localhost/views/");
            }
        }
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
        $token = self::getToken($provider);

        try {
            $user = $provider->getResourceOwner($token);
            $user_linkedin_id = $user->getId();

            if ($verify_exists) {
                $user_exists = checkSocialLoginId("linked_in_id", $user_linkedin_id);
                if ($user_exists) {
                    header("Location: http://localhost/views/sign-up.php?using=linked-in&error=" . ERROR_CODE::$ALREADY_EXISTS);
                    exit();
                }
            }
            $user_data = [
                "first_name" => $user->getFirstName(),
                "last_name" => $user->getLastName(),
                "username" => strtok($user->getEmail(), '@'),
                "linked_in_id" => $user_linkedin_id,
                "error" => "",
            ];

            return $user_data;
        } catch (Exception $e) {
            echo $e;
            exit('Oh dear...');
        }
    }
}


class GoogleSocialLogin extends SocialLogin
{
    public static function getProvider()
    {
        $redirect_page = self::getRedirectUrl("google", GoogleConfig::$REDIRECT_URI);
        $provider = new Google([
            'clientId'     => GoogleConfig::$CLIENT_ID,
            'clientSecret' => GoogleConfig::$CLIENT_SECRET,
            'redirectUri'  => $redirect_page,
        ]);
        return $provider;
    }

    public static function getDetails($verify_exists = true)
    {
        $provider = self::getProvider();
        $token = self::getToken($provider);


        try {
            $user = $provider->getResourceOwner($token);
            $user_google_id = $user->getId();

            if ($verify_exists) {
                $user_exists = checkSocialLoginId("google_id", $user_google_id);
                if ($user_exists) {
                    header("Location: http://localhost/views/sign-up.php?using=google&error=" . ERROR_CODE::$ALREADY_EXISTS);
                    exit();
                }
            }
            $user_data = [
                "first_name" => $user->getFirstName(),
                "last_name" => $user->getLastName(),
                "username" => strtok($user->getEmail(), '@'),
                "google_id" => $user_google_id,
                "error" => "",
            ];

            return $user_data;
        } catch (Exception $e) {
            echo $e;
            exit('Oh dear...');
        }
    }
}


class FacebookSocialLogin extends SocialLogin
{
    public static function getProvider()
    {
        $redirect_page = self::getRedirectUrl("facebook", FacebookConfig::$REDIRECT_URI);
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId'          => FacebookConfig::$APP_ID,
            'clientSecret'      => FacebookConfig::$APP_SECRET,
            'redirectUri'       => $redirect_page,
            'graphApiVersion'   => 'v2.10',
        ]);
        return $provider;
    }

    public static function getDetails($verify_exists = true)
    {
        $provider = self::getProvider();
        $token = self::getToken($provider);

        try {
            $user = $provider->getResourceOwner($token);
            $facebook_id = $user->getId();

            if ($verify_exists) {
                $user_exists = checkSocialLoginId("facebook_id", $facebook_id);
                if ($user_exists) {
                    header("Location: http://localhost/views/sign-up.php?using=facebook&error=" . ERROR_CODE::$ALREADY_EXISTS);
                    exit();
                }
            }
            $user_data = [
                "first_name" => $user->getFirstName(),
                "last_name" => $user->getLastName(),
                "username" => strtok($user->getEmail(), '@'),
                "facebook_id" => $facebook_id,
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
