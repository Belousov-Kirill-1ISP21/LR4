<?php
class Review {
    private $conn;
    
    public $id;
    public $user_id;
    public $rating;
    public $comment;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create() {
        $sql = "INSERT INTO reviews (user_id, rating, comment) 
                VALUES ($this->user_id, $this->rating, '$this->comment')";
        
        return mysqli_query($this->conn, $sql);
    }
}
?>