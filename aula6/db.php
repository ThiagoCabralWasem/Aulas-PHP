<?php
class Database {
    
    private $conn = null;


    public function __construct(string $servername, string $username, string $password, string $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . htmlspecialchars($this->conn->connect_error));
        }
        
        $this->conn->set_charset("utf8mb4");
    }
    
    public function create($arr, $table) {
        $raw = "INSERT INTO $table (";
        $keys = array_keys($arr);
        $values = array_values($arr);

        $raw_names = implode(", ", $keys);
        $raw_values = implode(", ", $values);

        $raw .= "$raw_names) VALUES ($raw_values);";
        return $raw;
    } 


}