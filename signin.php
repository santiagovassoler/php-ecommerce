<?php session_start();?>
<?php
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();
if(empty($_SESSION['user_id']))
{
if (!empty($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "") {
        $login_error_message = 'email field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $userRepository = new UserRepository();
        $user_id = $userRepository->userLogin($email,$password); // check user login
        if($user_id > 0)
        {
            $_SESSION['user_id'] = $user_id; // Set Session
            header("Location: profile.php"); // Redirect user to the profile.php
        }
        else
        {
            $login_error_message = 'Invalid login details!';
        }
    }
}
include_once("view/login.phtml");
} else{
    header("Location: index.php");
}
