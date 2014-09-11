<?php

require_once("View/HTMLView.php");
require_once("View/LoginView.php");
require_once('Controller/LoginController.php');

session_start();

$htmlView = new HTMLView();

$loginView = new LoginView();
$loginController = new LoginController();
$loginView->logOut();
$body = $loginController->renderHtml();
$htmlView->echoHTML($body);

