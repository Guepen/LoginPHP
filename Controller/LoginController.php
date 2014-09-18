<?php

require_once("./View/LoginView.php");
require_once("./View/HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/UserAgent.php");


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
            if (time() < $this->model->getCookieExpireTimeFromfile()) {
                $this->setUsername();
                $this->setDecryptedPassword();
                if ($this->model->doLogIn($this->username, $this->password, "Inloggning lyckades via cookies")) {
                    $userAgent = new UserAgent();
                    $this->userAgent = $userAgent->getUserAgent();
                    $this->model->setUserAgent($this->userAgent);

                    $this->setMessage();
                    $this->showLoggedInPage = true;
                }
                else{

                    $this->loginView->setMessage("Felaktig information i cookie");
                    $this->loginView->unsetCookies();
                }

            }
            else{
                $this->loginView->setMessage("Felaktig information i cookie");
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
                    $msg = "Inloggningen lyckades och vi kommer komma ihåg dig nästa gång";
                }
                else{
                    $msg = "Inloggningen lyckades!";
                }


                $this->setUsername();
                $this->setPassword();

                if ($this->model->doLogIn($this->username, $this->password,$msg )) {
                    $userAgent = new UserAgent();
                    $this->userAgent = $userAgent->getUserAgent();
                    $this->encryptPassword();
                    $this->model->setCookieExpireTime();
                    $this->getCookieExpireTime();
                    $this->model->writeCookieExpireTimeToFile();
                    $this->loginView->setCookie();
                    $this->setMessage();
                    $this->model->setUserAgent($this->userAgent);
                    $this->showLoggedInPage = true;

                } else {
                    $this->setMessage();
                    $this->showLoggedInPage = false;
                }

            } else{
                $this->showLoggedInPage = false;
            }
        }
    }



    public function isLoggedIn(){
       $userAgent = new UserAgent();
       $this->userAgent2 = $userAgent->getUserAgent();
        if($this->model->isLoggedIn() && $this->model->checkUserAgent($this->userAgent2)){
            //var_dump("controller: isLoggedIn: true");
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

    public function encryptPassword(){
       $this->loginView->setEncryptedPassword($this->model->encryptedPassword($this->loginView->getPassword()));
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

    public function setDecryptedPassword(){
        $this->password = $this->model->decryptPassword($this->loginView->getCookiePassword());
    }

    public function getUserAgent(){
        return $this->userAgent;
    }

    public function getUserAgent2(){
        return $this->userAgent2;
    }

    public function getCookieExpireTime(){
        $this->loginView->setCookieExpireTime($this->model->getCookieExpireTime());
    }
}