<?php

require_once('./Controller/LoginController.php');

class LoginModel{
    private $username = 'Admin';
    private $password = 'password';
    private $message;

    /**
     * @param $username
     * @param $password
     * @return bool true if user is authenticated, else false
     */
    public function doLogIn($username, $password){
        if (empty($_POST['username']) || empty($_POST['username']) && empty($_POST['password'])) {
            $this->message = 'missing username';

        }
        else if (empty($_POST['password'])) {
            $this->message = 'missing password';

        }

        else if($username !== $this->username || $password !== $this->password){
            $this->message = "username and/or password is wrong";
        }

        else if ($username === $this->username && $password === $this->password) {
            if (isset($_SESSION['loggedIn']) == false) {
                $_SESSION['loggedIn'] = $username;
            }

            $this->message = "You have successfully logged in";

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
        $this->message = "Logged out";
        session_unset("loggedIn");
    }

    public function getMessage(){
        return $this->message;
    }

    public function getUsername(){
        return $_SESSION['loggedIn'];
    }

}