<?php

require_once('./Controller/LoginController.php');

class LoginModel{
    private $username = 'Admin';
    private $password = 'password';
    private $message;
    private $userAgent;
    private $userAgent2;


    /**
     * @param $username
     * @param $password
     * @return bool true if user is authenticated, else false
     */
    public function doLogIn($username, $password, $message){
        if (empty($_POST['username']) || empty($_POST['username']) && empty($_POST['password'])) {
            $this->message = 'missing username';

        }
        else if (empty($_POST['password'])) {
            $this->message = 'missing password';

        }

        else if($username !== $this->username || $password !== $this->password){
            $this->message = "username and/or password is wrong";
        }

        if ($username === $this->username && $password === $this->password) {

            if (isset($_SESSION['loggedIn']) == false) {
                $_SESSION['loggedIn'] = $username;
            }

            $this->message = $message;

            return true;

        }

        return false;

    }

    public function isLoggedIn(){
        if (isset($_SESSION['loggedIn'])){
            return true;
        }
    }

    public function doLogOut(){
        if (isset($_SESSION['loggedIn'])) {
            $this->message = "Logged out";
            session_unset("loggedIn");
        }
    }

    public function getMessage(){
        return $this->message;
    }

    public function getUsername(){
        return $_SESSION['loggedIn'];
    }

    public function userAgentExists(){
        if(isset($_SESSION['userAgent'])){
            return true;
        }
    }

    public function checkUserAgent($ua){
        if(isset($_SESSION['userAgent'])){
            //var_dump("model: checkUserAgent", $ua);
            if($ua === $_SESSION['userAgent']){
                var_dump("model: checkUserAgent: true");
            return true;
            }
        }

    }

    public function setUserAgent($userAgent){
        if(isset($_SESSION['userAgent']) == false){
            $_SESSION['userAgent'] = $userAgent;
            //var_dump("model: setUserAgent", $_SESSION['userAgent']);
        }
    }

    public function getUserAgent(){
        return $_SESSION['userAgent'];
    }

    public function encryptedPassword($pwd){
        var_dump($pwd);
        return base64_encode($pwd);
    }

}