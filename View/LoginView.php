<?php

require_once("HTMLView.php");
require_once("./Model/LoginModel.php");
require_once("./helper/CookieStorage.php");

class LoginView{

    private $username;
    private $password;
    private $encryptedPassword;
    private $htmlView;
    private $cookie;
    private $model;
    private $cookiePassword;
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
        $username = "";
        if(isset($_POST['submit'])){
            $username = $this->username;
        }

        $html ="
                   <H3>Ej Inloggad</H3>
                    <form action=?login class='form-horizontal' method=post enctype=multipart/form-data>
                       <fieldset>
					      <legend>Skriv in användarnamn och lösenord</legend>
					      $this->message
					      <div class='form-group'>
					        <label class='col-sm-2 control-label' for=username>Användarnamn: </label>
					        <div class='col-sm-10'>
					          <input id='username' placeholder='Skriv in ditt användarnamn' class='form-control' value='$username' name='username' type=text size=20 />
					        </div>
					      </div>
					      <div class='form-group'>
					         <label class='col-sm-2 control-label' for='password'>Lösenord: </label>
					         <div class='col-sm-10'>
					           <input id='password' placeholder='Skriv in ditt lösenord' class='form-control' name='password' type=password size=20>
					         </div>
					      </div>
				          <div class='form-group'>
				             <div class='col-sm-offset-2 col-sm-10'>
				               <div class='checkbox'>
				                  <label>
					              <input class='checkbox' type='checkbox' name='checkbox'/> Håll mig inloggad
					              </label>
					           </div>
					         </div>
					      </div>
					     <div class='form-group'>
				           <div class='col-sm-offset-2 col-sm-10'>
					         <input class='btn btn-default' name='submit' type='submit' value='Logga in' />
					       </div>
					     </div>
					   </fieldset>
			       </form>

   ";
        return $html;
    }

    /**
     * @return bool true uf user has pressed login else false
     */
    public function didUserPressLogin(){
        if(isset($_POST['submit'])){
            return true;
        }
        return false;
    }

    /**
     * @return bool true if user has checked remember me else false
     */
    public function userHasCheckedKeepMeLoggedIn(){
        if(isset($_POST['checkbox'])){
            return true;
        }
        return false;

    }

    public function getAuthentication(){
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];

    }

    public function setCookie(){
        if (isset($_POST['checkbox'])) {
            $this->cookie->save("username", $this->username, $this->cookieExpireTime);
            $this->cookie->save("password", $this->encryptedPassword, $this->cookieExpireTime);
        }

    }

    /**
     * @return bool true if there is cookie to load, else false
     */
    public function loadCookie(){
        if (isset($_COOKIE['username'])) {
            $cookieUser = $this->cookie->load("username");
            $this->cookiePassword = $this->cookie->load("password");
            $this->username = $cookieUser;

            return true;
        }
        return false;
    }

    /**
     * Delete cookies
     */
    public function unsetCookies(){
        $this->cookie->save("username", null, time()-1);
        $this->cookie->save("password", null, time()-1);
    }

    /**
     * @param $message string message with feedback
     */
    public function setMessage($message){
        $this->message = $message;

    }

    /**
     * @return string username
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @return string password
     */

    public function getPassword(){
        return $this->password;
    }

    public function getEncryptedPassword(){
        return $this->encryptedPassword;
    }

    public function setEncryptedPassword($pwd){
        $this->encryptedPassword = $pwd;

    }

    public function setDecryptedPassword($pwd){
        $this->password = $pwd;
    }

    public function setCookieExpireTime($expireTime){
        $this->cookieExpireTime = $expireTime;
    }

    public function getCookiePassword(){
        return $this->cookiePassword;
    }
}