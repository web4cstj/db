<?php
namespace Web4cstj\DB;
use PDO;
class Database
{
    static protected $path = __DIR__ . "/../database/";
    static protected $db = "database";
    static protected $extension = ".sqlite";
    static protected $pdo = null;
    static public function connect()
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO("sqlite:" . static::$path . static::$db . static::$extension);
        }
        return self::$pdo;
    }
}
