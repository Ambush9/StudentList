<?php

namespace application\models;

use application\core\Model;

class Account extends Model {

    public $error;
    
    public function validate ($input, $post) {
		$rules = [
			'login'    => [
				'pattern' => '#^[a-z0-9]{3-15}$#',
				'message' => 'Логин указан неверно (Разрешены только латинские буквы и цифры от 3 до 15 символов)',
			],
			'password' => [
				'pattern' => '#^[a-z0-9]{5-20}$#',
				'message' => 'Пароль указан неверно (Разрешены только латинские буквы и цифры от 5 до 20 символов)',
			],
		];

		// валидация данных при регистрации
		foreach ($input as $val) {
			if (!isset($post[$val]) || empty($post[$val]) && !preg_match($rules[$val]['pattern'], $post[$val])) {
				$this->error = $rules[$val]['message'];
				return false;
			}
		}

		return true;
	}
	
	// проверяет уникальность логина
	public function checkLoginExists($login) {
		$params = [
			'login' => $login,
		];
		if ($this->db->column('SELECT id FROM users WHERE login = :login', $params)) {
			$this->error = 'Этот логин уже используется';
			return false;
		}
		return true;
	}

	public function register ($post) {
        $params = [
			"id" 	   => null,
			"login"    => $_POST['login'],
			"scores"   => 0,
			"password" => password_hash($_POST['password'], PASSWORD_BCRYPT),
		];

		$this->db->query("INSERT INTO users (id,login,scores,password) VALUES (:id,:login,:scores,:password)", $params);
	}

	public function login($login) {
		$params = [
			'login' => $login
		];
		$data = $this->db->row('SELECT * FROM users WHERE login = :login', $params);
		$_SESSION['account'] = $data[0];
	}

	public function checkData($login, $password) {
		$params = [
			'login' => $login
		];
		$hash = $this->db->column('SELECT password FROM users WHERE login = :login', $params);
		
		if (!$hash or !password_verify($password, $hash)) {
			return false;
		}
		return true;
	}
}