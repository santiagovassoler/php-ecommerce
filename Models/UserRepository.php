<?php

require_once ('Models/Database.php');
require_once ('Models/Products.php');
require_once ('Models/Pagination.php');
require_once ('Models/User.php');
require_once ('Models/Role.php');

class UserRepository {
  protected $_dbConnection, $_dbInstance;
  protected $userRoles = array();

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbConnection = $this->_dbInstance->getDbConnection();
    }
    public function fetchAll() {

        $sqlQuery = ('SELECT * FROM user ORDER BY user_id DESC' );

        $statement = $this->_dbConnection->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new User($row);
        }
        return $dataSet ;
    }

    public function addUser(User $user){
      $stmt= $this->_dbConnection->beginTransaction();
      $stmt = $this->_dbConnection->prepare(
        "INSERT INTO user(
          email,first_name,last_name,password,address, mobile_number)
        VALUES (
          :email, :first_name ,:last_name,:password,:address, :mobile_number)
        ");

      $stmt->bindParam(':email', $this->checkEmail($user->getEmail()));
      $stmt->bindParam(':first_name', $user->getFirstName());
      $stmt->bindParam(':last_name', $user->getLastName());
      $stmt->bindParam(':password', password_hash($user->getPassword(),PASSWORD_DEFAULT));
      $stmt->bindParam(':address', $user->getAddress());
      $stmt->bindParam(':mobile_number', $user->getMobileNumber());
      $stmt->execute();

      $stmt = $this->_dbConnection->prepare("SELECT user_id from user WHERE email=:email");
      $stmt->bindParam(':email', $user->getEmail());
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $user_id = $row["user_id"];
        }
      $stmt= $this->_dbConnection->commit();
      $_SESSION['user_id'] = $user_id; // Set Session
      header("Location: profile.php");

  }
    public function checkEmail($email)
    {
      $query = $this->_dbConnection->prepare("SELECT COUNT(*) AS count FROM user WHERE email = :email");
      $query->bindParam(":email", $email, PDO::PARAM_STR);
      $query->execute();
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
              $email_count = $row["count"];
        }
        if ($email_count > 0) {
          //echo "This email address is already in use";
        }else{
          return $email;
        }
      }

    public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }


   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_id']);
        header("Location:index.php");
        return true;
   }
   public function userLogin($email,$password)
   {
      $query = $this->_dbConnection->prepare("SELECT user_id, email , password FROM user WHERE email = :email");
      $query->bindParam(":email", $email,PDO::PARAM_STR) ;

      $query->execute();
			$results = $query->fetch(PDO::FETCH_ASSOC);
			if(count($results) > 0 && password_verify($password, $results['password'])){
        return $results['user_id'];
			}else{}
  }
  public function getUserDetails($user_id)
    {


            $query = $this->_dbConnection->prepare("SELECT user_id, email, first_name, last_name, address, mobile_number, reg_date FROM user WHERE user_id = :user_id");
            $query->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $query->execute(array(":user_id" => $user_id));
            //$result = $query->fetchAll();
            if($query->rowCount()==1){
              $_SESSION['userData'] = $userData = $query->fetch(PDO::FETCH_ASSOC);
              $this->user_id = $user_id;
              $this->email = $userData['email'];
              $this->first_name = $userData['first_name'];
              $this->last_name = $userData['last_name'];
              $this->address = $userData['address'];
              $this->mobile_number = $userData['mobile_number'];
              $this->reg_date = $userData['reg_date'];
              $this->loadRoles();
            //  var_dump($this->loadRoles());
            }
    }

    //Check if the user has a certain permission
    public function hasPermission($permission)
    {
    	//If the user has more roles, check them too
        foreach ($this->userRoles as $role)
        {

        	//Do the actual checking
            if ($role->verifyPermission($permission))
            {
                return true;
            }
        }
        return false;
    }
    public function loadRoles()
    {
        $fetchRoles = $this->_dbConnection->prepare("SELECT user_role.role_id, role.role_name FROM user_role JOIN role ON user_role.role_id = role.role_id WHERE user_role.user_id = :user_id");
        $fetchRoles->execute(array(":user_id" => $this->user_id));

        while($row = $fetchRoles->fetch(PDO::FETCH_ASSOC))
        {                                                 //rolepermission
            $this->userRoles[$row["role_name"]] = Role::getRole($row["role_id"]);
        }
    }

    public function addReview($review , $product_id, $user_id  ){
      $stmt = $this->_dbConnection->prepare(
        "INSERT INTO review(
          review, product_id, user_id)
        VALUES (
          :review, :product_id ,:user_id)
        ");

      $stmt->bindParam(':review', $review,PDO::PARAM_STR);
      $stmt->bindParam(':product_id', $product_id,PDO::PARAM_STR);
      $stmt->bindParam(':user_id', $user_id,PDO::PARAM_STR);
      $stmt->execute();
  }

    public function listOrders($user_id)
  {
    $query = $this->_dbConnection->prepare('SELECT o_i.* , p.name, p.image_name, p.price, o.order_date, o.order_total,o.status FROM order_items o_i INNER JOIN products p ON o_i.product_id = p.id LEFT JOIN orders o ON o_i.order_id = o.order_id WHERE o.user_id = :user_id');
    $query->bindParam(":user_id", $user_id, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }
  public function Delete($product_id)
  {
    $query = $this->_dbConnection->prepare("DELETE FROM user WHERE id = :id");
    $query->bindParam(":id", $product_id, PDO::PARAM_STR);
    $query->execute();
  }
}
