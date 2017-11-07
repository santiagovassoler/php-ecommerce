<?php
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();
$userRepository = new UserRepository();
$view->userRepository = $userRepository->listOrders($_SESSION['user_id']);
include_once("view/orders_list.phtml");
