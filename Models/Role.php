<?php
require_once ('Models/Database.php');

class Role {

    protected $permissions;
	  protected static $_dbConnection, $_dbInstance;

	//Initiate an empty array for the permissions
    public function __construct()
    {
        $this->permissions = array();
        self::$_dbInstance = Database::getInstance();
        self::$_dbConnection = self::$_dbInstance->getDbConnection();
    }
    //Create populate Role Object
    public static function getRole($role_id)
    {
        $role = new Role();//Create new role object

        //Prepate statement and execute it                                                            //permissions
        $stmt = self::$_dbConnection->prepare("SELECT permission.permission_description FROM role_permission JOIN permission ON role_permission.permission_id = permission.permission_id WHERE role_permission.role_id = :role_id");
        $stmt->execute(array(":role_id" => $role_id));

		//Loop through the results
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        /*  highlight_string("<?php\n\$data =\n" . var_export($row['permission_description'] , true) . ";\n?>"); */

            $role->permissions[$row["permission_description"]] = true;
        }
      /*  highlight_string("<?php\n\$data =\n" . var_export($role , true) . ";\n?>"); */
        return $role;

    }

    //Check if the specific role has a given permission
    public function verifyPermission($permission)
    {
        return isset($this->permissions[$permission]);
    }
}
