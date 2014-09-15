<?php

require_once("HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/CookieStorage.php");

class LoginView{

    private $username;
    private $password;
    private $htmlView;
    private $cookie;
    private $model;
    private $location = 'logOut';
    private $message;
    private $cookieExpireTime;

    public function __construct(){
        $this->htmlView = new HTMLView();
        $this->model = new LoginModel();
        $this->cookie = new CookieStorage();
    }

    /**
     * @return string with html-code
     */
    public function showLoginpage(){

        $html =" <h1>Laborationskod th222fa<h1/>
            <H3>Not logged in</H3>
            <form action=?login method=post enctype=multipart/form-data>
				<fieldset>

					<legend>Type in username and password</legend>
					<p>$this->message</p>
					<label for=username>Username: </label>
					<input value='$this->username' name='username' type=text size=20>
					<label for=username>Password: </label>
					<input name='password' type=password size=20>
					<input type='checkbox' name='checkbox'> Keep me logged in
					<input name='submit' type='submit' value='Login'>

				</fieldset>
			</form>

   ";

        return $html;
    }

    /**
     * @return string with html-code
     */
    public function showLoggedInPage(){
        $this->username = $this->model->getUsername();
        $html = "<h1>Laborationskod th222fa<h1/>
            <H3>$this->username Logged In :)</H3>
            <p>$this->message</p>
            <a name='logOut' href='?logOut'>sign out</a>
    ";
        return $html;
    }

    public function didUserPressLogOut(){
        if(isset($_GET[$this->location])){
            return true;
        }

    }

    public function didUserPressLogin(){
        if(isset($_POST['submit'])){
            return true;
        }
    }

    public function userHasCheckedKeepMeLoggedIn(){
        if(isset($_POST['checkbox'])){
            return true;
        }

    }


    public function getAuthentication(){

        $this->username = $_POST['username'];
        $this->password = $_POST['password'];

    }

    public function setCookie(){
        if (isset($_POST['checkbox'])) {
            $this->cookieExpireTime = time()+3600;
            var_dump($this->cookieExpireTime);
            $pwd = base64_encode($this->password);
            $this->cookie->save("username", $this->username);
            $this->cookie->save("password", $pwd);
        }

    }

    public function loadCookie(){
        if (isset($_COOKIE['username'])) {
            $cookieUser = $this->cookie->load("username");
            $cookiePassword = $this->cookie->load("password");
            $pwd = base64_decode($cookiePassword);

            $this->username = $cookieUser;
            $this->password = $pwd;
        }
    }

    /**
     * @return username
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @return password
     */
    public function getPassword(){
        return $this->password;
    }

    public function setMessage($message){
        $this->message = $message;

    }

    public function getCookieExpireTime(){
        return $this->cookieExpireTime;
    }

}