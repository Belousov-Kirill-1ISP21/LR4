<?php
class Application {
    private $conn;
    private $table_name = "applications";
    
    public $id;
    public $user_id;
    public $course_id;
    public $start_date;
    public $payment_method;
    public $status_id;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, course_id, start_date, payment_method, status_id) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iissi", 
            $this->user_id, $this->course_id, $this->start_date, $this->payment_method, $this->status_id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    public function getUserApplications($user_id) {
        $query = "SELECT a.*, c.name as course_name, c.price, c.teacher_name, s.name as status_name
                  FROM " . $this->table_name . " a 
                  JOIN courses c ON a.course_id = c.id 
                  JOIN application_statuses s ON a.status_id = s.id
                  WHERE a.user_id = ? 
                  ORDER BY a.id DESC";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        
        return mysqli_stmt_get_result($stmt);
    }
    
    public function getAllApplications() {
        $query = "SELECT a.*, u.full_name, u.login, c.name as course_name, c.teacher_name, s.name as status_name
                  FROM " . $this->table_name . " a 
                  JOIN users u ON a.user_id = u.id 
                  JOIN courses c ON a.course_id = c.id
                  JOIN application_statuses s ON a.status_id = s.id
                  ORDER BY a.id DESC";
        
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
    
    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $this->status_id, $this->id);
        return mysqli_stmt_execute($stmt);
    }
}
?>