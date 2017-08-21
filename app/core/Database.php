<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 08.07.17
 * Time: 19:52
 */

namespace core;

use \PDO;

class Database
{
    private static $engine = 'mysql';
    private static $host = 'localhost';
    private static $database = 'counter';
    private static $user = 'root';
    private static $pass = 'root';

    private static $_db = NULL;

    private function __construct(){}
    private function __sleep(){}
    private function __wakeup(){}
    private function __clone(){}

    public static function DB()
    {
        if(NULL === self::$_db)
            self::$_db = new PDO(
                self::$engine . ':host=' . self::$host . ';dbname=' . self::$database,
                self::$user,
                self::$pass
            );
        return self::$_db;
    }
}