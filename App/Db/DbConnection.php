<?php

namespace App\Db;

use \PDO;
class DbConnection {

    static private $_instance;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function getInstance() {
        if(self::$_instance instanceof DbConnection) {

        } else {
            try {
                self::$_instance = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                    DB_USER, DB_PASS, [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            } catch (\PDOException $e) {
                echo 'connection Error: ' . $e->getMessage();
            }
        }

        return self::$_instance;

    }

    public static function inquireIntoDb($query) {

        $sth = self::getInstance()->query($query);
        if(!empty($sth)) {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }



}