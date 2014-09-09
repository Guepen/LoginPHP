<?php

require_once("View/HTMLView.php");
require_once("View/LoginView.php");

$htmlView = new \view\HTMLView();

$loginView = new \view\LoginView();
$body = $loginView->showLoginpage();

$htmlView->echoHTML($body);