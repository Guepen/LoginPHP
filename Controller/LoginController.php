<?php

require_once("./View/LoginView.php");
require_once("./Model/LoginModel.php");


class LoginController{
    private $view;
    private $model;
    private $username;
    private $password;

    public function __construct(){
        $this->view = new LoginView();
        $this->model = new LoginModel();
    }

    /**
     * @return string|void
     */
    public function renderHtml(){

        if(isset($_SESSION['loggedIn'])){
            return $this->view->showLoggedInPage();
        }

        if(isset($_POST['submit'])){
            $this->view->getAuthentication();
            $this->getUsername();
            $this->getPassword();

            if($this->model->checkAuthentication($this->username, $this->password)){
                return $this->view->showLoggedInPage();

            }

        }

        else{
            return $this->view->showLoginpage();
        }

    }


    public function getUsername(){
        $this->username = $this->view->getUsername();

    }

    public function getPassword(){
        $this->password = $this->view->getPassword();
    }
}