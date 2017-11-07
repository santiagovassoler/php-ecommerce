<?php
session_start();
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();
$view->pageTitle = 'Logout';

if (isset($_SESSION['user_id']))  {
    //  unset($_SESSION['email']);
    //  header("Location: index.php");
$userRepository = new UserRepository();
$userRepository->logout();
}
include_once("view/index.phtml");
