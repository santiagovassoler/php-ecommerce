<?php
require_once('Models/UserRepository.php');
require_once('Models/Pagination.php');
$view = new stdClass();

$userRepository = new UserRepository();
$pagination = new Pagination();
$numbers = $pagination->paginate($userRepository->fetchAll(),5);
$data = $pagination->fetchResult();



require_once('view/user_list.phtml');
