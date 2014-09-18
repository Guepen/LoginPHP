<?php

class Message{
    private $messageId;
    private $messages = array('Användarnamn saknas', 'Lösenord saknas', "Felaktigt användarnamn och/eller lösenord",
                              "Felaktig information i cookie",  "Inloggning lyckades via cookies",
                              "Inloggningen lyckades och vi kommer komma ihåg dig nästa gång",
                              "Inloggningen lyckades!", "Du är nu utloggad!"
    );

    public function __construct($messageId){
        $this->messageId = $messageId;
    }

    /**
     * @return string html with feedback
     */
    public function getMessage(){
        $message = $this->messages[$this->messageId];
        if($this->messageId <4){
            $alert = "<div class='alert alert-danger alert-error'>";
        }
        else{
            $alert = "<div class='alert alert-success'>";
        }
        if(!empty($message)){
            $ret = "
                  $alert
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<p>$message</p>
					</div>

            ";
        }
        else{
            $ret = "<p>$message</p>";
        }
        return $ret;
    }
}