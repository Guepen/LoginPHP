<?php

require_once("./View/LoginView.php");
require_once("./View/HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/UserAgentView.php");


class LoginController{
    private $loginView;
    private $htmlView;
    private $model;
    private $username;
    private $password;
    private $userAgent;
    private $userAgent2;
    private $showLoggedInPage;

    public function __construct(){
        $this->loginView = new LoginView();
        $this->htmlView = new HTMLView();
        $this->model = new LoginModel();
    }

    /**
     *Call controlfunctions
     */
    public function doControl(){
        $this->doLogInCookie();
        $this->isLoggedIn();
        $this->doLogOut();
        $this->doLogIn();
        $this->renderPage();

    }

    public function doLogInCookie(){
            if (!$this->model->isLoggedIn() && !$this->loginView->didUserPressLogOut() && !$this->loginView->didUserPressLogin() && $this->loginView->loadCookie()) {
                if (time() < $this->loginView->getCookieExpireTime()) {
                $this->setUsername();
                $this->setPassword();
                if ($this->model->doLogIn($this->username, $this->password, "Logged in with cookie")) {
                        $userAgent = new UserAgent();
                        $this->userAgent = $userAgent->getUserAgent();
                        $this->model->setUserAgent($this->userAgent);

                    $this->setMessage();
                    $this->showLoggedInPage = true;
                    var_dump("doLoginCookie: doLogIn");
                    //$this->htmlView->echoHTML($this->view->showLoggedInPage());
                }
                    else{

                    $this->loginView->setMessage("Wrong information in cookie");
                    $this->loginView->unsetCookies();
                }


            }
                else{
                    $this->loginView->setMessage("Wrong information in cookie");
                    $this->loginView->unsetCookies();

                }
        }


    }


    public function doLogOut(){

        if ($this->model->isLoggedIn()) {
            if ($this->loginView->didUserPressLogOut()) {
                $this->model->doLogOut();
                $this->setMessage();
            }
        }
        }


    public function doLogIn(){
        //If not already logged in
        if (!$this->model->isLoggedIn()) {
            if ($this->loginView->didUserPressLogin()) {
                $this->loginView->getAuthentication();
                if($this->loginView->userHasCheckedKeepMeLoggedIn()){
                    $msg = "logged in successfully and we will remember you next time";
                }
                else{
                    $msg = "logged in successfully";
                }


                $this->setUsername();
                $this->setPassword();

                if ($this->model->doLogIn($this->username, $this->password,$msg )) {
                    $userAgent = new UserAgent();
                    $this->userAgent = $userAgent->getUserAgent();

                    $this->loginView->setCookie();
                    $this->setMessage();
                    $this->model->setUserAgent($this->userAgent);
                    var_dump("controller: doLogIn: loggedIn");
                    $this->showLoggedInPage = true;

                } else {
                    $this->setMessage();
                    var_dump("controller: doLogIn: loginFailed");
                    $this->showLoggedInPage = false;
                }

            } else{
                var_dump("controller: doLogIn: not logged in");
                $this->showLoggedInPage = false;
            }
        }
    }



    public function isLoggedIn(){
       $userAgent = new UserAgent();
       $this->userAgent2 = $userAgent->getUserAgent();
        if($this->model->isLoggedIn() && $this->model->checkUserAgent($this->userAgent2)){
            var_dump("controller: isLoggedIn: true");
            $this->showLoggedInPage = true;
        }
    }

    public function renderPage(){
        if($this->showLoggedInPage){
            $this->htmlView->echoHTML($this->loginView->showLoggedInPage());
        }
        else{
            $this->htmlView->echoHTML($this->loginView->showLoginpage());
        }
    }

    public function setMessage(){
        $this->loginView->setMessage($this->model->getMessage());
    }


    public function setUsername(){
        $this->username = $this->loginView->getUsername();

    }

    public function setPassword(){
        $this->password = $this->loginView->getPassword();
    }

    public function getUserAgent(){
        return $this->userAgent;
    }

    public function getUserAgent2(){
        return $this->userAgent2;
    }
}