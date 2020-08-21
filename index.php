<?php 

require 'application/lib/Dev.php';

use application\core\Router; // т.о можно обращаться к классу Router
                             // не указывая полный путь
// use не вызывает срабатывания автозагрузки
// Эта конструкция просто задает короткий синоним для длинного имени класса.

// автозагрузка файлов с классами
spl_autoload_register(function ($class) {
    
    $path = str_replace('\\', '/', $class. '.php');
    if (file_exists($path)) {
        require $path;
    }
});

session_start();

$router = new Router;
$router->run();
