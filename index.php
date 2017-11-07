<?php session_start();
require_once('Models/ProductRepository.php');
require_once('Models/Pagination.php');

$view = new stdClass();
$perpage = $_POST['numbers'];
$perpge = $_SESSION['qtyPerPage'];
if ($perpage == ""){
  $perpage = 4;
}
$productRepository = new ProductRepository();
$pagination = new Pagination();
$numbers = $pagination->paginate($productRepository->pagination(),$perpage);//8);
$data = $pagination->fetchResult();
require_once('view/index.phtml');
