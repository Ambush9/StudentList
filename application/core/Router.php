<?php

namespace application\core;

use application\core\View;

class Router {

    protected $routes = []; // тут хранится массив из routes.php
    protected $params = []; // сюда записываются параметры при совпадении маршрута(имя контроллера и действия)

    function __construct () {
        
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    // добавляет маршрут
    public function add($route, $params) {
        
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params; // делает массив routes рв
    }

    // берет запрошенный url и проверяет есть ли у нас такой маршрут
    public function match() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run() {
       if($this->match()) { // если маршрут найден
        
        // формируем путь до файла где лежит нужный контроллер
        $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';

        // проверяем есть ли такой класс(в файле всегда всего один класс)
        if (class_exists($path)) {
            
            // получаем действие и проверяем есть ли такой метод в контрллере
            $action = $this->params['action'] . 'Action';
            if (method_exists($path, $action)) {
                $controller = new $path($this->params); // создаем экземпляр класса + передали инфу о том на какой мы странице
                $controller->$action();   // вызываем нужный action
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
       } else {
        View::errorCode(404);
       }   
    }
}