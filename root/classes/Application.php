<?php
class Application {
    private $conn;
    private $table_name = "applications";
    
    public $id;
    public $user_id;
    public $course_id;
    public $start_date;
    public $payment_method;
    public $status;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, course_id, start_date, payment_method) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iiss", 
            $this->user_id, $this->course_id, $this->start_date, $this->payment_method);
        
        return mysqli_stmt_execute($stmt);
    }
    
    public function getUserApplications($user_id) {
        $query = "SELECT a.*, c.name as course_name, c.price, t.full_name as teacher_name
                  FROM " . $this->table_name . " a 
                  JOIN courses c ON a.course_id = c.id 
                  LEFT JOIN teachers t ON c.teacher_id = t.id
                  WHERE a.user_id = ? 
                  ORDER BY a.created_at DESC";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        
        return mysqli_stmt_get_result($stmt);
    }
    
    public function getAllApplications() {
        $query = "SELECT a.*, u.full_name, u.login, c.name as course_name, t.full_name as teacher_name
                  FROM " . $this->table_name . " a 
                  JOIN users u ON a.user_id = u.id 
                  JOIN courses c ON a.course_id = c.id
                  LEFT JOIN teachers t ON c.teacher_id = t.id
                  ORDER BY a.created_at DESC";
        
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    
    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $this->status, $this->id);
        return mysqli_stmt_execute($stmt);
    }
}
?>