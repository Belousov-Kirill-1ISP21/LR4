<?php
session_start();

class Database {
    private $host = "localhost";
    private $db_name = "korochki_est";
    private $username = "root";
    private $password = "usbw";
    public $conn;
    
    public function getConnection() {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        if (!$this->conn) {
            die("Connection error: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->conn, "utf8");
        return $this->conn;
    }
}

$database = new Database();
$db = $database->getConnection();
?>