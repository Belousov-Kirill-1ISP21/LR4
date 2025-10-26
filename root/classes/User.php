<?php
class User {
    private $conn;
    private $table_name = "users";
    
    public $id;
    public $login;
    public $password;
    public $full_name;
    public $phone;
    public $email;
    public $role_id;
    public $error;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (login, password, full_name, phone, email, role_id) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", 
            $this->login, $this->password, $this->full_name, 
            $this->phone, $this->email, $this->role_id);
        
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            $this->error = mysqli_error($this->conn);
        }
        
        return $result;
    }
    
    public function login() {
        $query = "SELECT id, password, role_id FROM " . $this->table_name . " WHERE login = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $this->login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if($this->password === $row['password']) {
                $this->id = $row['id'];
                $this->role_id = $row['role_id'];
                return true;
            }
        }
        return false;
    }
}
?>