<?php 

namespace application\controllers;

use application\core\Controller; // подключаем класс Controller
 
class AccountController extends Controller {

    public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'account';
    }
    
    // регистрация
    public function registerAction() {
		if (!empty($_POST)) {
			if (!$this->model->validate(['login','password'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			elseif (!$this->model->checkLoginExists($_POST['login'])) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->register($_POST);
            $this->view->message('success', 'Регистрация завершена, авторизируйтесь');
		}
        $this->view->render('Регистрация');
    }

    // авторизация
    public function loginAction () {

        if (!empty($_POST)) {
			if (!$this->model->validate(['login','password'], $_POST)) {
				$this->view->message('error', $this->model->error);
            }
            elseif (!$this->model->checkData($_POST['login'], $_POST['password'])) {
				$this->view->message('error', 'Логин или пароль указан неверно');
            }
            
			$this->model->login($_POST['login']);
			$this->view->location('main');
		}
        $this->view->render('Авторизация');
    }

    public function logoutAction () {
        unset($_SESSION['account']);
        $this->view->redirect('login');
    }

}