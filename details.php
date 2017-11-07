<?php
require_once('Models/ProductRepository.php');
require_once('Models/Products.php');
require_once('Models/Image.php');
require_once('Models/UserRepository.php');
$view = new stdClass();

if (isset($_GET['id']) && isset($_GET['id']) != "") {
    $product_id = $_POST['id'];

    $productRepository = new ProductRepository();
    $view->productRepository = $productRepository->Details($product_id);

}
require_once('view/edit.phtml');
