<?php
class Course {
    private $conn;
    
    public $id;
    public $name;
    public $description;
    public $price;
    public $teacher_id;
    public $duration_hours;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getAll() {
        $sql = "SELECT c.*, t.full_name
                FROM courses c 
                LEFT JOIN teachers t ON c.teacher_id = t.id";
        
        return mysqli_query($this->conn, $sql);
    }
}
?>