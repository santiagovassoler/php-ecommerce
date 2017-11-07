<?php session_start();
require_once('Models/ProductRepository.php');
require_once('Models/Products.php');
require_once('Models/User.php');
require_once('Models/Cart.php');

$cart = new Cart;

require_once('view/viewCart.phtml');
