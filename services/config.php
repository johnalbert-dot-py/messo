<?php


class ERROR_CODE
{
    public static $ALREADY_EXISTS = 1; // when something already exists
    public static $DATABASE_ERROR = 2;
    public static $INVALID_ACCOUNT = 3;
}


class LinkedInConfig
{
    public static $CLIENT_ID = '866y3tf8mik0gm';
    public static $CLIENT_SECRET = '2HAxXgsGTO4TE66L';
    public static $REDIRECT_URI = 'http://localhost/views/';
}

class MicrosoftConfig
{
    public static $APP_ID = "f6718016-e0ca-477e-bb95-cbc10408fc44";
    public static $TENNANT_ID = "14ef7792-dfb2-45cb-9077-165f359154ad";
    public static $SECRET_KEY = "e660612a-728f-4b78-8521-de9de16ce9cf";
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
    public static $CLIENT_ID = '368377028020-isg5m4srca4kshl91le3i6vebh27cac6.apps.googleusercontent.com';
    public static $CLIENT_SECRET = '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';
    public static $REDIRECT_URI = "http://localhost/views/";
}
