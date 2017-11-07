<?php session_start();
require_once('Models/ProductRepository.php');
require_once('Models/Products.php');
$view = new stdClass();


    if(isset($_POST['q'])){
      $search = $_POST['q'];

      if($search !=""){
      $productRepository = new ProductRepository();
      $view->productRepository = $productRepository->searchItem($search);
    //  $productRepository->search($search);
  }}
include_once("view/result_list.phtml");
