<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/services/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/services/social-auths.php");

$provider = GoogleSocialLogin::getProvider();

if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} else if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
}
