<?php

namespace view;
class LoginView{

    /**
     * @return string with htmlcode
     */
    public function showLoginpage(){
        $html = "<h1>Laborationskod th222fa<h1/>
            <H3>Not logged in</H3>
            <form action=?login method=post enctype=multipart/form-data>
				<fieldset>

					<legend>Type in username and password</legend>
					<label for=username>Username: </label>
					<input type=text size=20>
					<label for=username>Password: </label>
					<input type=password size=20>
					<input type='submit' value='Login'>

				</fieldset>
			</form>

    ";

    return $html;
}

}