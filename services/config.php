<?php


class ERROR_CODE
{
    public static $ALREADY_EXISTS = 1; // when something already exists
    public static $DATABASE_ERROR = 2;
    public static $INVALID_ACCOUNT = 3;
}


class LinkedInConfig
{
    public static $CLIENT_ID = '';
    public static $CLIENT_SECRET = '';
    public static $REDIRECT_URI = 'http://localhost/views/';
}

class MicrosoftConfig
{
    public static $APP_ID = "";
    public static $TENNANT_ID = "";
    public static $SECRET_KEY = "";
    public static $REDIRECT_URI = "http://localhost/views/";

    public static function getLoginUrl($redirect_uri = "")
    {
        $redirect_uri = $redirect_uri ? $redirect_uri : self::$REDIRECT_URI;
        $login_uri = "https://login.microsoftonline.com/" . self::$TENNANT_ID . "/oauth2/v2.0/authorize?";
        return $login_uri . http_build_query([
            "client_id" => self::$APP_ID,
            "response_type" => "token",
            "redirect_uri" => $redirect_uri,
            "scope" => "https://graph.microsoft.com/User.Read"
        ]);
    }
}


class GoogleConfig
{
    public static $CLIENT_ID = '';
    public static $CLIENT_SECRET = '';
    public static $REDIRECT_URI = "http://localhost/views/";
}


class FacebookConfig
{
    public static $APP_ID = "";
    public static $APP_SECRET = "";
    public static $REDIRECT_URI = "http://localhost/views/";
}
