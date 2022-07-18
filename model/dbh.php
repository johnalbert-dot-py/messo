<?php

class DBH
{

    private static $host = "localhost";
    private static $user = "root";
    private static $pwd = "";
    private static $dbName = "messo";
    public static $table = "";
    public static $dbh;

    public static function staticConnect()
    {
        try {
            self::$dbh = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbName, self::$user, self::$pwd);
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$dbh;
        } catch (PDOException $e) {
            print $e;
        }
    }

    public static function execute_sql($sql = "", $values = [], $fetch = false)
    {
        try {
            $stmt = self::staticConnect()->prepare($sql);
            foreach ($values as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
            if ($fetch) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return self::$dbh->lastInsertId();
            }
        } catch (PDOException $e) {
            print $e;
            return 0;
        }
    }
}
