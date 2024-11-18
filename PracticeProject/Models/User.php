<?php
include_once "Models/Model.php";

class User extends Model {
    public $id;
    public $username;
    public $password;
    public $isAdmin;

    function __construct($id = -1){
        parent::__construct();  
        if ($id >= 0) {
            $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `id` = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            if ($result) {
                $this->id = $result['id'];
                $this->username = $result['username'];
                $this->password = $result['password'];
                $this->isAdmin = $result['isAdmin'];
            }
            $stmt->close();
        }
    }

    public function register($username, $password, $isAdmin = false){
        $hashedPassword = sha1($password); // Hash the password using SHA1
        $stmt = $this->conn->prepare("INSERT INTO `users` (`username`, `password`, `isAdmin`) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $hashedPassword, $isAdmin);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    

    public function login($username, $password) {
        // Hash the input password using SHA1
        $hashedPassword = sha1($password);
    
        // Prepare the SQL query with the hashed password
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    
        // Return user data if found, otherwise return false
        return $result ? $result : false;
    }
    
    

    public static function isAdmin(){
        return isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
    }

}
?>
