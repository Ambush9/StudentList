<?php

// Базовый класс с моделями, который будут наследовать все модели

namespace application\core;

use application\lib\Db;

abstract class Model {
    
    public $db;

    public function __construct () {
        $this->db = new Db;
    } 
}