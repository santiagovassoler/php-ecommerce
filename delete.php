<?php
require_once('Models/ProductRepository.php');

if (isset($_POST['id']) && isset($_POST['id']) != "") {
    $user_id = $_POST['id'];

    $productRepository = new ProductRepository();
    $productRepository->Delete($user_id);
}
