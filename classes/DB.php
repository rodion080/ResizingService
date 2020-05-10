<?php
namespace classes;
use PDO;

class DB{

    protected $pdo;

    public function __construct(){
        $dbConfig = require 'configs/db.php';
        $this->pdo=new PDO('mysql:host='
            .$dbConfig['host'].';dbname='
            .$dbConfig['dbname'], ''
            .$dbConfig['user'], ''
            .$dbConfig['password']);
        if (!$this->pdo){
            die("Error connect to DataBase");
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($statement, $values=""){
        return $this->query($statement, $values)->fetchAll(PDO::FETCH_ASSOC);
    }


}