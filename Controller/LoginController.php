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
        $this->doLogInCookie();
        $this->doLogIn();



    }

    public function doLogInCookie(){

        if (!$this->model->isLoggedIn() && !$this->view->didUserPressLogOut() && !$this->view->didUserPressLogin()) {
            $this->view->loadCookie();
            $this->setUsername();
            $this->setPassword();
            if ($this->model->doLogIn($this->username, $this->password, "Logged in with cookie")) {
                $this->setMessage();
                $this->htmlView->echoHTML($this->view->showLoggedInPage());

            }

            else{
                $this->view->setMessage("Wrong information in cookie");
            }
        }


    }

    public function doLogOut(){

            if ($this->view->didUserPressLogOut()) {
                $this->model->doLogOut();
                $this->setMessage();
            }
        }


    public function doLogIn(){
        //If not already logged in
        if (!$this->model->isLoggedIn()) {
            if ($this->view->didUserPressLogin()) {
                $this->view->getAuthentication();
                if($this->view->userHasCheckedKeepMeLoggedIn()){
                    $msg = "logged in successfully and we will remember you next time";
                }
                else{
                    $msg = "logged in successfully";
                }


                $this->setUsername();
                $this->setPassword();

                if ($this->model->doLogIn($this->username, $this->password,$msg )) {
                    $this->view->setCookie();
                    $this->setMessage();
                    $this->htmlView->echoHTML($this->view->showLoggedInPage());

                    var_dump($this->view->getCookieExpireTime(), time()+36);


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