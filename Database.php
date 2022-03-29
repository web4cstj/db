<?php
namespace Web4cstj\DB;
use PDO;
class Database
{
    static public $path = __DIR__ . "/../database/";
    static public $db = "database";
    static public $extension = ".sqlite";
    static public $pdo = null;
    static public function connect()
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO("sqlite:" . static::$path . static::$db . static::$extension);
        }
        return self::$pdo;
    }
}
