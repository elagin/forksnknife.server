<?php

class ApkDB {

    const HOST = 'apk.host';
    const LOGIN = 'apk.login';
    const PASS = 'apk.password';
    const DB = 'apk.db';

    private static $pdo = null;

    public static function getInstance() {
        if (self::$pdo == null) {
            $host = Config::get(self::HOST);
            $db = "forksnknife";
            $charset = "utf8";
            $user = Config::get(self::LOGIN);
            $pass = Config::get(self::PASS);
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
            self::$pdo = new PDO($dsn, $user, $pass, $opt);

            $setNames = "SET NAMES 'utf8'";
            $setCharacterSet = "SET CHARACTER SET 'utf8'";
            $setSession = "SET SESSION collation_connection = 'utf8_general_ci'";
            self::$pdo->exec($setNames);
            self::$pdo->exec($setCharacterSet);
            self::$pdo->exec($setSession);
            //mysql_query("SET NAMES 'utf8'"); 
            //mysql_query("SET CHARACTER SET 'utf8'");
            //mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");
        }
        return self::$pdo;
    }

    private function __construct() {
        
    }

    public static function getFields($allowed) {
        $res = "";
        foreach ($allowed as $field) {
            if (strlen($res) > 0)
                $res = $res . ", ";
            $res = $res . $field;
        }
        return $res;
    }

    public static function getPlaceHolders($allowed) {
        $res = "";
        foreach ($allowed as $field) {
            if (strlen($res) > 0)
                $res = $res . ", ";
            $res = $res . ":" . $field;
        }
        return $res;
    }

    public static function getFieldPlace($allowed) {
        $res = "";
        foreach ($allowed as $field) {
            if (strlen($res) > 0) {
                $res = $res . ", ";
            }
            $res = $res . $field . "= :" . $field;
        }
        return $res;
    }

}
