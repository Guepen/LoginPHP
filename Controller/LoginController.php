<?php

require_once("./View/LoginView.php");
require_once("./View/HTMLView.php");
require_once("./Model/LoginModel.php");


class LoginController{
    private $view;
    private $htmlView;
    private $model;
    private $username;
    private $password;

    public function __construct(){
        $this->view = new LoginView();
        $this->htmlView = new HTMLView();
        $this->model = new LoginModel();
    }

    /**
     *Call controlfunctions
     */
    public function doControl(){

        $this->doLogOut();
        $this->isLoggedIn();
        $this->doLogIn();

    }

    public function doLogOut(){
        if ($this->model->isLoggedIn()) {
            if ($this->view->didUserPressLogOut()) {
                $this->model->doLogOut();
                $this->setMessage();
            }
        }
    }

    public function doLogIn(){

        //If not already logged in
        if (!$this->model->isLoggedIn()) {
            if ($this->view->didUserPressLogin()) {
                $this->view->getAuthentication();
                $this->setUsername();
                $this->setPassword();

                if ($this->model->doLogIn($this->username, $this->password)) {
                    $this->setMessage();
                    $this->htmlView->echoHTML($this->view->showLoggedInPage());


                } else {
                    $this->setMessage();
                    $this->htmlView->echoHTML($this->view->showLoginpage());
                }

            } else {
                $this->htmlView->echoHTML($this->view->showLoginpage());
            }
        }

    }

    public function isLoggedIn(){
        if($this->model->isLoggedIn()){
            $this->htmlView->echoHTML($this->view->showLoggedInPage());
        }
    }

    public function setMessage(){
        $this->view->setMessage($this->model->getMessage());
    }


    public function setUsername(){
        $this->username = $this->view->getUsername();

    }

    public function setPassword(){
        $this->password = $this->view->getPassword();
    }
}