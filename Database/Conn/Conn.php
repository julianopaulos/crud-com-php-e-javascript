<?php
    require_once __DIR__ . '/../../Core/Config.php';

    class Conn{
        private static $dbhost = DBHOST;
        private static $dbname = DBNAME;
        private static $dbuser = DBUSER;
        private static $dbpass = DBPASS;
        private static $connection = false;

        private static function setConn(){
            try{
                if(self::$connection === false){
                    self::$connection = new \PDO('mysql:host='.self::$dbhost.';dbname='.self::$dbname,self::$dbuser,self::$dbpass,
                    array(\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
                }
            }catch(\PDOException $error){
                die($error->getMessage());
            }
            return self::$connection;
        }
        public function getConn(){
            return self::setConn();
        }
    }