<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'scandiweb';
    private $username = 'root';
    private $password = 'root';
    private $port = 3308;

    // private $host = 'localhost';
    // private $db_name = 'aqaralex_scandiweb_test';
    // private $username = 'aqaralex_scandiweb';
    // private $password = 'i5,aiMUVb{-,';
    // private $port = 3306;
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            // Include the port in the DSN string
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}