<?php

namespace application\lib;

use PDO;

class Db {

    protected $db;

    public function __construct () {
        
        $config = require 'application/config/db.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
    }

    // делает запрос в БД
	public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        // $stmt->bindParam(':id',      $params['id']);
        // $stmt->bindParam(':login',   $params['login']);
        // $stmt->bindParam(':scores',  $params['scores']);
        // $stmt->bindParam(':password',$params['password']);

        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val); 
            }
        }

		$stmt->execute($params);
		return $stmt;
    }

    // public function query($sql, $params = []) {
    //     $stmt = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  
        // if (!empty($params)) {
        //     foreach ($params as $key => $val) {
        //         $stmt->bindValue(':'.$key, $val); 
        //     }
        // }
  
    //     $stmt->execute($params);
    //     return $stmt;
    // }
    

    public function row ($query, $params = []) {
        $result = $this->query($query, $params);
        return $result->fetchALl(PDO::FETCH_ASSOC);
    }

    public function column ($query, $params = []) {
        $result = $this->query($query, $params);
        return $result->fetchColumn();
    }

    public function lastInsertId() {
		return $this->db->lastInsertId();
	}
}