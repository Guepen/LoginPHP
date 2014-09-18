<?php

require_once('./Controller/LoginController.php');

class LoginModel{
    private $username = 'Admin';
    private $password = 'Password';
    private $messageId;
    private $cookieExpireTime;

    /**
     * @param $username
     * @param $password
     * @param $messageId mixed if an error occurs the messageId will be set
     * @return bool true if user is authenticated, else false
     */
    public function doLogIn($username, $password, $messageId){
       if (empty($username) || empty($username) && empty($password)) {
           $this->messageId = 0;

        }
        else if (empty($password)) {
            $this->messageId = 1;

        }

        else if($username !== $this->username || $password !== $this->password){
            $this->messageId = 2;
        }

        if ($username === $this->username && $password === $this->password) {
            if (isset($_SESSION['loggedIn']) == false) {
                $_SESSION['loggedIn'] = $username;
            }

            $this->messageId = $messageId;

            return true;

        }

        return false;

    }

    /**
     * @return bool true if we have a session with the user, else false
     */
    public function isLoggedIn(){
        if (isset($_SESSION['loggedIn'])){
            return true;
        }
        return false;
    }

    /**
     * logs out the user
     */
    public function doLogOut(){
        if (isset($_SESSION['loggedIn'])) {
            $this->messageId = 7;
            session_unset("loggedIn");
        }
    }

    /**
     * @return mixed messageId
     */
    public function getMessage(){
        return $this->messageId;
    }

    /**
     * sets the messageId
     * @param $msgId
     */
    public function setMessage($msgId){
        $this->messageId = $msgId;
    }

    /**
     * @return mixed the username
     */
    public function getUsername(){
        return $_SESSION['loggedIn'];
    }

    /**
     * @param $ua string containing user agent
     * @return bool true if the user agent($ua) is the logged in user agent, else someone is trying to hack the session
     */
    public function checkUserAgent($ua){
        if(isset($_SESSION['userAgent'])){
            if($ua === $_SESSION['userAgent']){
            return true;
            }
        }
        return false;

    }

    /**
     * if the user has logged in
     * save his user agent in session
     * @param $userAgent string containing the user agent
     */
    public function setUserAgent($userAgent){
        if(isset($_SESSION['userAgent']) == false){
            $_SESSION['userAgent'] = $userAgent;
        }
    }

    /**
     * @return mixed the saved user agent
     */
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