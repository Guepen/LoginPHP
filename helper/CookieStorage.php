<?php


class CookieStorage {

    public function save($name, $user){
        setcookie($name, $user, time()+36);

    }

    public function load($name){
        $ret ="";
        if(isset($_COOKIE[$name])){
           $ret = $_COOKIE[$name];
        }

        return $ret;

    }
}