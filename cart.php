<?php session_start();
require_once('Models/ProductRepository.php');
require_once('Models/Products.php');
require_once('Models/User.php');
require_once('Models/Cart.php');

$view = new stdClass();
// initialize shopping cart class
$cart = new Cart;
$productRepository = new ProductRepository();
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){

$productID = $_REQUEST['id'];
$row = $productRepository->Details($productID);

          $itemData = array(
              'id' => $row['id'],
              'name' => $row['name'],
              'price' => $row['price'],
              'image_name' => $row['image_name'],
              'qty' => 1
          );

        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'viewCart.php':'index.php';
        header("Location: ".$redirectLoc);
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){

        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: viewCart.php");
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){

      if(!isset($_SESSION["user_id"])){
        header("Location: signin.php");
      }else{

       $productRepository->checkoutOrder($_SESSION['sessCustomerID'],$cart->total());
       $cartItems = $cart->contents();
       foreach($cartItems as $item){
            $productRepository->checkoutOrder_items($item['id'],$item['qty']);
          }
          $productRepository->commit_and_update();
          $cart->destroy();
          $to = $_SESSION["userData"]['email'];
          $subject = "Your order has submitted successfully";
          $message = "Hello! Thank you for shopping with us, you can now track your orders in your profile account. T-Mania Team.";
          $from = "lza854";
          $headers = "From: $from";
          mail($to,$subject,$message,$headers);
          header("Location: ordersuccess.php");
      }
  }
}
