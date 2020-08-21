<?php 

namespace application\controllers;

use application\core\Controller; // подключаем класс Controller
use application\lib\Db;
 
class MainController extends Controller {
    
    public function indexAction () {
        $studentList = $this->model->getStudentList(10, 0);
        $vars = [
            'studentList' => $studentList
        ];
        
        $this->view->render('Главная страница', $vars);
    }
}