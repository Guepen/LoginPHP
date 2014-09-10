<?php

class HTMLView {

    /**
     * @param $body HTML-code
     * @throws \Exception if $body is null
     */
    Public function echoHTML($body){
       if($body == NULL){
            throw new \Exception("Body is null");
       }

        echo "
				<!DOCTYPE html>
				<html>
				<body>
					$body
				</body>
				</html>";

    }
}