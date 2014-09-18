<?php
require_once("./View/LoginView.php");
require_once("./Model/LoginModel.php");

class LoggedInView{
    private $model;
    private $message;
    private $username;
    private $logOutLocation = 'logOut';

    public function __construct(){
        $this->model = new LoginModel();
    }

    /**
     * @return string with html
     */
    public function showLoggedInPage(){
        $this->username = $this->model->getUsername();
        $html = "
            <H3>$this->username är inloggad :)</H3>
            $this->message
            <a class='btn btn-default' name='logOut' href='?logOut'>Logga ut</a>
    ";
        return $html;
    }

    /**
     * @return bool true if user has pressed log out else false
     */
    public function didUserPressLogOut(){
        if(isset($_GET[$this->logOutLocation])){
            return true;
        }
        return false;

    }

    /**
     * @param $message string containing feedback
     */
    public function setMessage($message){
        $this->message = $message;
    }
}