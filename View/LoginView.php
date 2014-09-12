<?php

require_once("HTMLView.php");

class LoginView{

    private $username;
    private $password;
    private $htmlView;
    private $location = 'logOut';
    private $message = '';
    private $feedback = 'You have successfully logged in!';

    public function __construct(){
        $this->htmlView = new HTMLView();
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
        $this->username = $_SESSION['loggedIn'];
        $html = "<h1>Laborationskod th222fa<h1/>
            <H3>$this->username Logged In :)</H3>
            <p>$this->message</p>
            <a name='logOut' href='?logOut'>sign out</a>
    ";
        return $html;
    }

    public function logOut(){
        if(isset($_GET[$this->location])){
            session_unset('loggedIn');
        }
    }


    public function getAuthentication(){
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
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

    public function successfullLogin(){
        $this->feedback = "You have successfully logged in";
    }

}