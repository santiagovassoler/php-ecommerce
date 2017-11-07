<?php session_start();
require_once('Models/ProductRepository.php');
require_once('Models/Pagination.php');
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();
$productRepository = new ProductRepository();
$pagination = new Pagination();
$numbers = $pagination->paginate($productRepository->pagination(),5);
$data = $pagination->fetchResult();

if(isset($_SESSION["user_id"]))
{
    $user = new UserRepository();
    $user->getUserDetails($_SESSION["user_id"]);

	if ($user->hasPermission("add product"))
	{
    require_once('view/dashboard.phtml');
  }
  else{
    header("Location: index.php");
  }
}
