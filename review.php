<?php session_start();?>
<?php
require_once('Models/UserRepository.php');
require_once('Models/User.php');
$view = new stdClass();
$userRepository = new UserRepository();
if(isset($_SESSION['user_id'])){

if (isset($_POST['user_id']) && isset($_POST['product_id']) && isset($_POST['review'])){
  $product_id = $_POST['product_id'];
  $user_id = $_POST['user_id'];
  $review = $_POST['review'];

  $userRepository->addReview($review , $product_id, $user_id);

}
}else{
  echo '<div class="alert alert-danger">';
  echo "<strong>You need to sign in first</strong></div>";
}
require_once('view/prod.phtml');
