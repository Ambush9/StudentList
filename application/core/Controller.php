<?php

namespace application\core;

use application\core\View;

abstract class Controller {

    public $route;
    public $view;
    public $acl;

    // инфа в конструктор передается при вызове экз.кл: new Class($arg)
    public function __construct ($route) {
        $this->route = $route; // теперь эту переменную можно юзать в наследуемых классах($this->route)
        // if (!$this->checkAcl()) {
		// 	View::errorCode(403);
        // }        
        $this->view = new View($route); // передали маршрут в View
        $this->model = $this->loadModel($route['controller']); 
    }                          
    
    // подключает нужную модель в контроллер
    public function loadModel ($name) {
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    // проверяет есть ли у пользователя доступ
    public function checkAcl () {
        $this->acl = require 'application/acl/'.$this->route['controller'].'.php';
        if ($this->isAcl('all')) {
			return true;
		}
		elseif (isset($_SESSION['authorize']['id']) and $this->isAcl('authorize')) {
			return true;
		}
		elseif (!isset($_SESSION['authorize']['id']) and $this->isAcl('guest')) {
			return true;
		}
		elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
			return true;
		}
		return false;
    }

    public function isAcl($key) {
		return in_array($this->route['action'], $this->acl[$key]);
	}

}