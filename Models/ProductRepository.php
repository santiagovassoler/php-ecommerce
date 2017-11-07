<?php

require_once ('Models/Database.php');
require_once ('Models/Products.php');
require_once ('Models/Pagination.php');

class ProductRepository {
  protected $_dbConnection, $_dbInstance;

  public function __construct() {
    $this->_dbInstance = Database::getInstance();
    $this->_dbConnection = $this->_dbInstance->getDbConnection();
  }
  function getTimestamp(){
    date_default_timezone_set('Europe/London');
    $this->timestamp = date('d-m-Y H:i:s');
  }
  public function add(Products $products){
    $stmt = $this->_dbConnection->prepare(
      "INSERT INTO products(
        name,price,description,category_id,stock_qty, image_name)
        VALUES (
          :name, :price ,:description,:category_id,:stock_qty, :image_name)
          ");

          $stmt->bindParam(':name', $products->getProductName());
          $stmt->bindParam(':price', $products->getPrice());
          $stmt->bindParam(':description', $products->getDescription());
          $stmt->bindParam(':category_id', $products->getCategoryID());
          $stmt->bindParam(':stock_qty', $products->getStockQty());
          $stmt->bindParam(':image_name', $products->getImageName());

          if($stmt->execute()){

            echo '<div class="alert alert-success">';
            echo '<strong>Product Added with Success!</strong></div>';
          }else{
            echo '<div class="alert alert-danger">';
            echo "<strong>Oh snap! Something's wrong..</strong></div>";
          }
        }
        public function update(Products $products)
        {
          $stmt = $this->_dbConnection->prepare('UPDATE products
            SET name = :name,
            price = :price,
            description = :description,
            category_id = :category_id,
            stock_qty = :stock_qty,
            image_name = :image_name
            WHERE id = :id
            ');

            $stmt->bindParam(':name', $products->getProductName());
            $stmt->bindParam(':price', $products->getPrice());
            $stmt->bindParam(':description', $products->getDescription());
            $stmt->bindParam(':category_id', $products->getCategoryID());
            $stmt->bindParam(':stock_qty', $products->getStockQty());
            $stmt->bindParam(':image_name', $products->getImageName());
            $stmt->bindParam(':id', $products->getProductId());
            //return $stmt->execute();
            if($stmt->execute()){
              echo '<div class="alert alert-success">';
              echo '<strong>Product Updated with Success!</strong></div>';
            }else{
              echo '<div class="alert alert-danger">';
              echo "<strong>Oh snap! plese check all inputs</strong></div>";
            }
          }
          public function findAll(){
            $sqlQuery = 'SELECT * FROM products';

            $statement = $this->_dbConnection->prepare($sqlQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement
            $dataSet = [];
            while ($row = $statement->fetch()) {
              $dataSet[] = new Products($row);
            }
            return $dataSet;
          }

          public function fetchAll() {

            $sqlQuery = ('SELECT * FROM products ORDER BY id DESC' );//.$pages->get_limit();

            $statement = $this->_dbConnection->prepare($sqlQuery);
            $statement->execute();

            $dataSet = [];
            while ($row = $statement->fetch()) {
              $dataSet[] = $row;
            }
            return $dataSet ;
          }

          public function listReviews($product_id)
          {
            $product_id = $_GET['id'];
            $query = $this->_dbConnection->prepare('SELECT review, first_name FROM review, user WHERE product_id=:product_id AND review.user_id = user.user_id AND status=1');
            $query->bindParam(":product_id", $product_id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
          }

          public function Details($product_id)
          {
            $product_id = $_GET['id'];
            $query = $this->_dbConnection->prepare("SELECT * FROM products WHERE id = :id");
            $query->bindParam(":id", $product_id, PDO::PARAM_STR);
            $query->execute();
            $details = $query->fetch(PDO::FETCH_ASSOC);
            $obj = $this->listReviews($product_id);
            $result = array_merge((array)$details, (array)$obj);
            return $result;
          }
          public function Delete($product_id)
          {
            $query = $this->_dbConnection->prepare("DELETE FROM products WHERE id = :id");
            $query->bindParam(":id", $product_id, PDO::PARAM_STR);
            $query->execute();
          }
          public function search($q){
            $query = $this->_dbConnection->prepare("SELECT * FROM products WHERE name LIKE '%".$q."%'");
            $query->execute();
            echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));

          }
          public function searchItem($q){
            $query = $this->_dbConnection->prepare("SELECT * FROM products WHERE name LIKE '%".$q."%'");
            $query->bindParam(":q", $q, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
              $result = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $result;
          }
        /*
        public function updateImage($id, $image)
        {
        $query = $this->_dbConnection->prepare("UPDATE products SET image_name = :image WHERE id = :id");
        $query->bindParam(":id", $id, PDO::PARAM_STR);
        $query->bindParam(":image", $image, PDO::PARAM_STR);
        $query->execute();

      }
      */
      public function pagination() {
        $fieldNameMapping = array ( 'price-asc'=>'price ASC',
                                    'price-desc'=>'price DESC',
                                    'category'=>'category_id',
                                    'name'=>'name',
                                  );

        if (!empty($sort)) {
        $sqlQuery = ('SELECT * FROM products ORDER BY ' . $fieldNameMapping[ $_POST['order'] ] . ' ');
      }else{
        $sqlQuery = ('SELECT * FROM products ORDER BY id DESC');//.$pages->get_limit();
      }
        //$sqlQuery = ('SELECT * FROM products ORDER BY id DESC');//.$pages->get_limit();
        $sqlQuery = $this->_dbConnection->prepare($sqlQuery); // prepare a PDO statement
        $sqlQuery->execute(); // execute the PDO statement
        while ($row = $sqlQuery->fetch()) {
          $dataSet[] = new Products($row);
        }
        return $dataSet;
      }

      public function listOrders($user_id)
      {

        $user_id = $_GET['user_id'];
        $query = $this->_dbConnection->prepare('SELECT image_name , name, price from products, order_items ,orders where products.id = order_items.product_id AND orders.user_id = :user_id');
        $query->bindParam(":user_id", $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
      }

      public function checkoutOrder($user_id,$order_total)
      {
        $query= $this->_dbConnection->beginTransaction();
        $query= $this->_dbConnection->prepare('INSERT INTO orders (user_id,order_total) VALUES (:user_id,:order_total)');
        $query->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $query->bindParam(":order_total", $order_total, PDO::PARAM_STR);
        $query->execute();
        //$query= $this->_dbConnection->commit();
      }

      public function checkoutOrder_items($product_id,$item_qty)
      {
      //  $query= $this->_dbConnection->beginTransaction();
        $query= $this->_dbConnection->prepare('INSERT INTO order_items(order_id, product_id,item_qty) VALUES (LAST_INSERT_ID(), :product_id, :item_qty)');
        $query->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $query->bindParam(":item_qty", $item_qty, PDO::PARAM_STR);
        $query->execute();

        $query=$this->_dbConnection->prepare('UPDATE products set stock_qty=stock_qty-:item_qty where id =:product_id');
        $query->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $query->bindParam(":item_qty", $item_qty, PDO::PARAM_STR);
        $query->execute();
      }
      public function commit_and_update()
      {
        $query= $this->_dbConnection->commit();
      }
    }
