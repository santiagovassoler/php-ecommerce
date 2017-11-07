<?php session_start();
require_once('Models/ProductRepository.php');
$view = new stdClass();

$productRepository = new ProductRepository();

$id = $_GET['id'];
$view->productRepository = $productRepository->Details($id);

require_once('view/prod.phtml');
