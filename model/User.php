<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/model/dbh.php");

class User extends DBH
{

    public static function create($first_name, $last_name, $username, $email, $password, $linked_in_id = "", $microsoft_id = "", $apple_id = "", $facebook_id = "", $google_id = "")
    {
        $sql = "INSERT INTO user (
            first_name,
            last_name,
            username,
            email,
            password,
            linked_in_id,
            microsoft_id,
            apple_id,
            facebook_id,
            google_id
        ) VALUES (:first_name, :last_name, :username, :email, :password, :linked_in_id, :microsoft_id, :apple_id, :facebook_id, :google_id)";
        return parent::execute_sql($sql, [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "linked_in_id" => $linked_in_id,
            "microsoft_id" => $microsoft_id,
            "apple_id" => $apple_id,
            "facebook_id" => $facebook_id,
            "google_id" => $google_id,
        ]);
    }
}
