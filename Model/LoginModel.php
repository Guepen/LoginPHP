<?php

require_once('./Controller/LoginController.php');

class LoginModel{
    private $username = 'Admin';
    private $password = 'password';

    /**
     * @param $username
     * @param $password
     * @return bool true if user is authenticated, else false
     */
    public function checkAuthentication($username, $password){
        if($username == $this->username && $password == $this->password){
            return true;

        }

        return false;

    }




}