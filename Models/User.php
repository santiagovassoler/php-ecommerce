<?php

class User {

  protected $_id, $_email, $_firstName, $_lastName, $_password, $_address, $_mobileNumber, $_regDate;

  public function __construct($dbRow) {
      $this->_id = $dbRow['user_id'];
      $this->_email = $dbRow['email'];
      $this->_firstName = $dbRow['first_name'];
      $this->_lastName = $dbRow['last_name'];
      $this->_password  = $dbRow['password'];
      $this->_address = $dbRow['address'];
      $this->_mobileNumber = $dbRow['mobile_number'];
      $this->_regDate = $dbRow['reg_date'];
  }

  public function getUserID() {
      return $this->_id;
  }
  public function getEmail(){
    return $this->_email;
  }
  public function getFirstName(){
    return $this->_firstName;
  }
  public function getLastName(){
    return $this->_lastName;
  }
  public function getPassword(){
    return $this->_password;
  }
  public function getAddress(){
    return $this->_address;
  }
  public function getMobileNumber(){
    return $this->_mobileNumber;
  }
  public function getRegDate(){
    return $this->_regDate;
  }
}
