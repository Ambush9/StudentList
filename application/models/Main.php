<?php

namespace application\models;

use application\core\Model; // подключаем базовый класс моделей

class Main extends Model {

    // получить список всех студентов
    public function getStudentList($limit, $offset) {

        // todo не получилось забиндить лимит и оффсет через переменные
        $data = $this->db->row('SELECT * FROM users ORDER BY id LIMIT 50 OFFSET 0');
        return $data;
    }
}