<?php

require_once("View/HTMLView.php");
require_once("View/LoginView.php");
require_once('Controller/LoginController.php');

$htmlView = new HTMLView();

$loginView = new LoginView();
$loginController = new LoginController();
$body = $loginController->renderHtml();
$htmlView->echoHTML($body);

