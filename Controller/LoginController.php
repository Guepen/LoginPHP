<?php

require_once("./View/LoginView.php");
require_once("./View/LoggedInView.php");
require_once("./View/HTMLView.php");
require_once("./View/Message.php");
require_once("./Model/LoginModel.php");
require_once("./Helper/UserAgent.php");


class LoginController{
    private $htmlView;
    private $loggedInView;
    private $loginView;
    private $model;
    private $username;
    private $password;
    private $userAgent;
    private $userAgent2;
    private $showLoggedInPage;

    public function __construct(){
        $this->loginView = new LoginView();
        $this->htmlView = new HTMLView();
        $this->loggedInView = new LoggedInView();
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

    /**
     * test to login with cookie
     */
    public function doLogInCookie(){
        if (!$this->model->isLoggedIn() && !$this->loggedInView->didUserPressLogOut() && !$this->loginView->didUserPressLogin() && $this->loginView->loadCookie()) {
            if (time() < $this->model->getCookieExpireTimeFromfile()) {
                $this->setUsername();
                $this->setDecryptedPassword();
                $msgId = 4;

                //if user can log in with cookies
                if ($this->model->doLogIn($this->username, $this->password, $msgId)) {
                    $userAgent = new UserAgent();
                    $this->userAgent = $userAgent->getUserAgent();
                    $this->model->setUserAgent($this->userAgent);

                    $this->setMessage();
                    $this->showLoggedInPage = true;
                }
                //if the password or username in the cookie was wrong
                else{
                    $msgId = 3;
                    $this->model->setMessage($msgId);
                    $this->setMessage();
                    $this->loginView->unsetCookies();
                }

            }
            //if the cookie had expired
            else{
                $msgId = 3;
                $this->model->setMessage($msgId);
                $this->setMessage();
                $this->loginView->unsetCookies();

            }
        }

    }

    /**
     * Checks if the user has pressed log out
     */
    public function doLogOut(){

        if ($this->model->isLoggedIn()) {
            if ($this->loggedInView->didUserPressLogOut()) {
                $this->model->doLogOut();
                $this->setMessage();
            }
        }
    }

    /**
     * try to login
     */
    public function doLogIn(){
        //If not already logged in
        if (!$this->model->isLoggedIn()) {
            if ($this->loginView->didUserPressLogin()) {
                $this->loginView->getAuthentication();
                if($this->loginView->userHasCheckedKeepMeLoggedIn()){
                    $msgId = 5;
                }
                else{
                    $msgId = 6;
                }

                $this->setUsername();
                $this->setPassword();

                if ($this->model->doLogIn($this->username, $this->password,$msgId )) {
                    $this->setMessage();
                    $userAgent = new UserAgent();
                    $this->userAgent = $userAgent->getUserAgent();
                    $this->encryptPassword();
                    $this->model->setCookieExpireTime();
                    $this->getCookieExpireTime();
                    $this->model->writeCookieExpireTimeToFile();
                    $this->loginView->setCookie();
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

    /**
     * checks if we have logged in session and checks so the session isnt hacked
     */
    public function isLoggedIn(){
        $userAgent = new UserAgent();
        $this->userAgent2 = $userAgent->getUserAgent();
        if($this->model->isLoggedIn() && $this->model->checkUserAgent($this->userAgent2)){
            $this->showLoggedInPage = true;
        }
    }

    /**
     * decides which view that should be rendered
     */
    public function renderPage(){
        if($this->showLoggedInPage){
            $this->htmlView->echoHTML($this->loggedInView->showLoggedInPage());
        }
        else{
            $this->htmlView->echoHTML($this->loginView->showLoginpage());
        }
    }

    public function encryptPassword(){
        $this->loginView->setEncryptedPassword($this->model->encryptedPassword($this->loginView->getPassword()));
    }

    public function setMessage(){
        $message = new Message($this->model->getMessage());
        if (!$this->model->isLoggedIn()) {
            $this->loginView->setMessage($message->getMessage());
        }
        else{
            $this->loggedInView->setMessage($message->getMessage());
        }
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