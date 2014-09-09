<?php

namespace view;
class HTMLView {

    /**
     * @param $body HTMLcode
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