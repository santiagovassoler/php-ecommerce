<?php session_start();?>
<?php
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();
if(empty($_SESSION['user_id']))
{
  header("Location: signin.php");
}

$userRepository = new UserRepository();
$view->userRepository = $userRepository->getUserDetails($_SESSION['user_id']);
include_once("view/profile.phtml");
