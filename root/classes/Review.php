<?php
class Review {
    private $conn;
    private $table_name = "reviews";
    
    public $id;
    public $user_id;
    public $rating;
    public $comment;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, rating, comment) 
                  VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iis", $this->user_id, $this->rating, $this->comment);
        
        return mysqli_stmt_execute($stmt);
    }
}
?>