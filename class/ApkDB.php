<?php
class ApkDB
{
    const HOST  = 'apk.host';
    const LOGIN = 'apk.login';
    const PASS  = 'apk.password';
    const DB    = 'apk.db';

    private static $pdo = null;

    public static function getInstance()
    {
        if (self::$pdo == null) {
            $host = Config::get(self::HOST);
            $db = "forksnknife";
            $charset = "utf8";
            $user = Config::get(self::LOGIN);
            $pass = Config::get(self::PASS);
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = array(
			  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
	    self::$pdo = new PDO($dsn, $user, $pass, $opt);
        }
        return self::$pdo;
    }

    private function __construct()
    {

    }
}
