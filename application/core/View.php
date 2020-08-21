<?php

namespace application\core;

class View {

    public $path;
    public $route;
    public $layout = 'default'; // хранит в себе названия шаблонов

    public function __construct ($route) {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }
    
    public function render ($title, $vars = []) {
        
        extract($vars);
        $path = 'application/views/' . $this->path . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean(); // получает содержимое буфера и передает в отображение
            require 'application/views/layouts/' . $this->layout . '.php';
        } else {
            echo "Вид не найден" . $this->path;
        }
    }

    public static function errorCode ($code) {
        
        http_response_code($code);

        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    // можно дергать из контроллеров через $this->view->redirect()
    public function redirect ($url) {
        header('location:' . $url);
        exit;
    }

    public function message ($status, $message) {
        exit(json_encode(['status'=>$status, 'message'=>$message]));
    }

    // редирект для JavaScript
    public function location ($url) {
        exit(json_encode(['url'=>$url]));
    }
}