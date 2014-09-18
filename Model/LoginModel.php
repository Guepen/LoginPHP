<?php

require_once('./Controller/LoginController.php');

class LoginModel{
    private $username = 'Admin';
    private $password = 'Password';
    private $message;
    private $cookieExpireTime;

    /**
     * @param $username
     * @param $password
     * @param $message
     * @return bool true if user is authenticated, else false
     */
    public function doLogIn($username, $password, $message){
       if (empty($username) || empty($username) && empty($password)) {
            $this->message = 'Användarnamn saknas';

        }
        else if (empty($password)) {
            $this->message = 'Lösenord saknas';

        }

        else if($username !== $this->username || $password !== $this->password){
            $this->message = "Felaktigt användarnamn och/eller lösenord";
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
        return false;
    }

    public function doLogOut(){
        if (isset($_SESSION['loggedIn'])) {
            $this->message = "Du är nu utloggad!";
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
        return false;
    }

    public function checkUserAgent($ua){
        if(isset($_SESSION['userAgent'])){
            if($ua === $_SESSION['userAgent']){
                //var_dump("model: checkUserAgent: true");
            return true;
            }
        }
        return false;

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

    public function setCookieExpireTime(){
        $this->cookieExpireTime = time()+250;
    }

   public function getCookieExpireTime(){
        return $this->cookieExpireTime;
    }

    public function encryptedPassword($pwd){
        return base64_encode($pwd);
    }

    public function decryptPassword($pwd){
        return base64_decode($pwd);
    }

    public function writeCookieExpireTimeToFile(){
        file_put_contents("expire.txt", $this->cookieExpireTime);
    }

    public function getCookieExpireTimeFromFile(){
        return file_get_contents("expire.txt");
    }

}