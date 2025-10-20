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
    public $status_id;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (login, password, full_name, phone, email, status_id) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", 
            $this->login, $this->password, $this->full_name, 
            $this->phone, $this->email, $this->status_id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    public function login() {
        $query = "SELECT id, password, status_id FROM " . $this->table_name . " WHERE login = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $this->login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if($this->password === $row['password']) {
                $this->id = $row['id'];
                $this->status_id = $row['status_id'];
                return true;
            }
        }
        return false;
    }
    
    public function checkLoginExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE login = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $this->login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }
}
?>