<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/services/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/services/social-auths.php");

$provider = MicrosoftSocialLogin::getProvider();
