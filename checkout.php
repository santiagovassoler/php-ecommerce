<?php session_start();
require_once('Models/ProductRepository.php');
require_once('Models/UserRepository.php');
require_once('Models/Products.php');
require_once('Models/User.php');
require_once('Models/Cart.php');
require_once ('Models/Database.php');
$view = new stdClass();

$cart = new Cart;
$userRepository = new UserRepository;
// redirect to home if cart is empty
if($cart->total_items() <= 0){
    header("Location: index.php");
}
// set customer ID in session
$_SESSION['sessCustomerID'] = 1;
// get customer details by session customer ID
$custRow = $userRepository->getUserDetails($_SESSION['sessCustomerID']);
require_once('view/checkout.phtml');
///$query = $db->query("SELECT * FROM customers WHERE id = ".$_SESSION['sessCustomerID']);
///$custRow = $query->fetch_assoc();
