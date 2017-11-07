<?php

class Products {

  protected $_id, $_name, $_price, $_description, $_categoryId, $_stockQty, $_timestamp, $_imageName;

  public function __construct($dbRow){
    $this->_id = $dbRow['id'];
    $this->_name = $dbRow['name'];
    $this->_price = $dbRow['price'];
    $this->_description = $dbRow['description'];
    $this->_categoryId = $dbRow['category_id'];
    $this->_stockQty = $dbRow['stock_qty'];
    $this->_timestamp = $dbRow['timestamp'];
    $this->_imageName = $dbRow['image_name'];


  }
  public function getProductID(){
    return $this->_id;
  }
  public function getProductName(){
    return $this->_name;
  }
  public function getPrice(){
    return $this->_price;
  }
  public function getDescription(){
    return $this->_description;
  }
  public function getCategoryID(){
    return $this->_categoryId;
  }
  public function getStockQty(){
    return $this->_stockQty;
  }
  public function getTimestamp(){
    return $this->_timestamp;
  }
  public function getImageName(){
    return $this->_imageName;
  }
  public function setName($_name){
    $this->$_name = $_name;
  }
  public function setPrice($_price){
    $this->$_price = $_price;
  }
  public function setDescription($_description){
    $this->$_description = $_description;
  }
  public function setCategoryID($_categoryId){
    $this->$_categoryId = $_categoryId;
  }
  public function setStockQty($_stockQty){
    $this->$_stockQty = $_stockQty;
  }
  public function setTimestamp($_timestamp){
    $this->$_timestamp = $_timestamp;
  }
  public function setImageName($_imageName){
    $this->$_imageName = $_imageName;
  }
}
