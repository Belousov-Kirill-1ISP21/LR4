<?php
class User {
    private $conn;
    
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
        $sql = "INSERT INTO users (login, password, full_name, phone, email, status_id) 
                VALUES ('$this->login', '$this->password', '$this->full_name', '$this->phone', '$this->email', $this->status_id)";
        
        return mysqli_query($this->conn, $sql);
    }
    
    public function login() {
        $sql = "SELECT id, password, status_id FROM users WHERE login = '$this->login'";
        $result = mysqli_query($this->conn, $sql);
        
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
        $sql = "SELECT id FROM users WHERE login = '$this->login'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
}
?>