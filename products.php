<?php session_start();

require_once('Models/ProductRepository.php');
require_once('Models/Products.php');
require_once('Models/Image.php');
require_once('Models/UserRepository.php');
$view = new stdClass();


$productRepository = new ProductRepository();

if(isset($_SESSION["user_id"]))
{
    $user = new UserRepository();
    $user->getUserDetails($_SESSION["user_id"]);

	if ($user->hasPermission("add product"))
	{
if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])
     && isset($_POST['category_id'])&& isset($_POST['stock_qty'])) {
			$image = new Image();
			$image->setDestination('img/');
			$image->setFileName($_FILES['image']['name']);//['tmp_name']);

      if($_FILES['image']['name']=='')
{
    $img = 'default.jpg';
}else{
  $img = $_FILES['image']['name'];


      $image->upload($_FILES['image']);
}

      if($image->error == ''){
                $data = array (
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description'],
                    'category_id' => $_POST['category_id'],
                    'stock_qty' => $_POST['stock_qty'],
                    'image_name' => $img//$_FILES['image']['name']

                  );

        $products = new Products($data);
        $productRepository->add($products);
      }else{
          echo "  , please try again";
      }
    }
}else{
    echo "permission denied";

}
require_once('view/products.phtml');
}
