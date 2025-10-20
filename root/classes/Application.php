<?php
class Application {
    private $conn;
    
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
        $sql = "INSERT INTO applications (user_id, course_id, start_date, payment_method) 
                VALUES ($this->user_id, $this->course_id, '$this->start_date', '$this->payment_method')";
        
        return mysqli_query($this->conn, $sql);
    }
    
    public function getUserApplications($user_id) {
        $sql = "SELECT a.*, c.name as course_name, c.price, t.full_name as teacher_name
                FROM applications a 
                JOIN courses c ON a.course_id = c.id 
                LEFT JOIN teachers t ON c.teacher_id = t.id
                WHERE a.user_id = $user_id 
                ORDER BY a.created_at DESC";
        
        return mysqli_query($this->conn, $sql);
    }
    
    public function getAllApplications() {
        $sql = "SELECT a.*, u.full_name, u.login, c.name as course_name, t.full_name as teacher_name
                FROM applications a 
                JOIN users u ON a.user_id = u.id 
                JOIN courses c ON a.course_id = c.id
                LEFT JOIN teachers t ON c.teacher_id = t.id
                ORDER BY a.created_at DESC";
        
        return mysqli_query($this->conn, $sql);
    }
    
    public function updateStatus() {
        $sql = "UPDATE applications SET status = '$this->status' WHERE id = $this->id";
        return mysqli_query($this->conn, $sql);
    }
}
?>