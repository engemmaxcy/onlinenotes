<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'onssdb';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            exit("Connection failed: " . $this->conn->connect_error);
        }

        // Set character set to utf8
        $this->conn->set_charset("utf8");

        return $this->conn;
    }
}

// Usage:
// $database = new Database();
// $db = $database->connect();
?>
