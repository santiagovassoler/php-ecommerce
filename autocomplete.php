<?php
require_once('Models/ProductRepository.php');

//if (isset($_GET['tags']) && isset($_GET['tags']) != "") {
      $q = $_POST['q'];

      $productRepository = new ProductRepository();
      $productRepository->search($q);

//  }
