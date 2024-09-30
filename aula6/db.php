<?php
class Database {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "bloco-de-notas";
    
    private $conn;


    public function __construct() {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . htmlspecialchars($this->conn->connect_error));
        }
        
        $this->conn->set_charset("utf8mb4");
    }
    
    public function create($arr, $table) {
        foreach $arr
    }


}
?>