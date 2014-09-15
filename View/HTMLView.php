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
        setlocale(LC_TIME, "sve");
        $date = strftime("%A, den %#d %B %Y. Klockan är [%X]");

        echo "
				<!DOCTYPE html>
				<html>
				<head>
				<meta charset='utf-8'>
				</head>
				<body>
					$body
                    <p>$date</p>
				</body>
				</html>";

    }

}