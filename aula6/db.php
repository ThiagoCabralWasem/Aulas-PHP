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

    public function getConnection() {
        return $this->conn;
    }

    public function create($arr, $id, $table) {
        $raw = "INSERT INTO $table (";
        $keys = array_keys($arr);
        $values = array_values($arr);
        $raw_names = implode(", ", $keys);
        $raw_values = implode("', '", $values);
        $raw .= "$raw_names, fk_categoria) VALUES ('$raw_values', $id);";
        $this->conn->query($raw);
    }

    public function read($table) {
        return $this->conn->query("SELECT * FROM $table");
    }

    public function update($arr, $id, $table) {
        $set = "";
        foreach ($arr as $key => $value) {
            $set .= "$key = '$value', ";
        }
        $set = rtrim($set, ", ");
        return $this->conn->query("UPDATE $table SET $set WHERE id = $id");
    }

    public function delete($id, $table) {
        return $this->conn->query("DELETE FROM $table WHERE id = $id");
    }

    public function getCategorias() {
        return $this->read('categoria');
    }

    public function getNota($id) {
        return $this->conn->query("SELECT * FROM nota WHERE id = $id")->fetch_assoc();
    }
}
?>
