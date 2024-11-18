<?php
class Model {
    protected $conn;

    public function __construct() {
        $this->conn = $this->establishDatabaseConnection();
    }

    protected static function establishDatabaseConnection() {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'event_manager';

        $connection = new mysqli($host, $username, $password, $database);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }
}
?>
