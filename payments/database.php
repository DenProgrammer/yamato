<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined( 'MYPAYMENT' ) or die( 'Restricted access' );

class database {

    protected static $_instance;
    protected static $db;
    protected static $host;
    protected static $user;
    protected static $pass;
    protected static $pdo;

    protected function __construct() {
        $config = new JConfig();
        self::$host = $config->host;
        self::$db = $config->db;
        self::$user = $config->user;
        self::$pass = $config->password;

        self::init();
    }

    protected function __clone() {
        
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new database();
        }

        return self::$_instance;
    }

    protected static function init() {
        $host = self::$host;
        $base = self::$db;
        $dsn  = "mysql:host=$host;dbname=$base;charset=utf8";
        $opt  = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        );
        self::$pdo = new PDO($dsn, self::$user, self::$pass, $opt);
    }

    public function query($sql, $params) {
        $pdo = self::$pdo;
        $stm = $pdo->prepare($sql);
        $stm->execute($params);

        return $stm->fetchAll();
    }

}
