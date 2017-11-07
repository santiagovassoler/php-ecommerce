<?php session_start();
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();


$userRepository = new UserRepository();
if(empty($_SESSION['user_id']))
{
  if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password'])
  && isset($_POST['mobile_number']) && isset($_POST['address']) && isset($_POST['email'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $mobile_number = trim($_POST['mobile_number']);
    $address = trim($_POST['address']);


    if ($first_name == "") {
      $register_error_message = 'first name field is required!';
    } else if ($last_name == "") {
      $register_error_message = 'last name field is required!';
    } else if ($password ==""){
      $register_error_message = 'password is required!';
    } else if ($email ==""){
      $register_error_message = 'email field is required!';
    }else if ($mobile_number==""){
      $register_error_message = 'mobile number name field is required!';
    }else if ($address==""){
      $register_error_message = 'address field is required!';
    }else if(!$userRepository->checkEmail($email)){
      $register_error_message = 'email already in use';
    } else {
      $data = array (
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => $password,
        'mobile_number' => $mobile_number,
        'address' => $address,
      );
    }
    $user = new User($data);
    $userRepository->addUser($user);
  }else{
    //header("Location: profile.php");
  }
}
header("Location: profile.php");
require_once('view/login.phtml');
