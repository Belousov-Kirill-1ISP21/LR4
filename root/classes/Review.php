<?php
class Review {
    private $conn;
    private $table_name = "reviews";
    
    public $id;
    public $user_id;
    public $course_id;
    public $rating;
    public $comment;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, course_id, rating, comment) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iiis", 
            $this->user_id, $this->course_id, $this->rating, $this->comment);
        
        return mysqli_stmt_execute($stmt);
    }
    
    public function getCourseReviews($course_id) {
        $query = "SELECT r.*, u.full_name 
                  FROM " . $this->table_name . " r 
                  JOIN users u ON r.user_id = u.id 
                  WHERE r.course_id = ? 
                  ORDER BY r.created_at DESC";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $course_id);
        mysqli_stmt_execute($stmt);
        
        return mysqli_stmt_get_result($stmt);
    }
    
    public function getCourseRating($course_id) {
        $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count 
                  FROM " . $this->table_name . " 
                  WHERE course_id = ?";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $course_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
}
?>