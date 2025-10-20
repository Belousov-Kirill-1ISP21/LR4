<?php
class Course {
    private $conn;
    private $table_name = "courses";
    
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
        $query = "SELECT c.*, t.full_name
                  FROM " . $this->table_name . " c 
                  LEFT JOIN teachers t ON c.teacher_id = t.id";
        
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
}
?>