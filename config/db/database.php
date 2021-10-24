<?php

class DataBase
{
    private $server_name = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "ess";
    private $connection = null;

    //connecting database and setting connection property of class with connection object
    public function __construct()
    {
        $conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);

        if ($conn->connect_error) {
            die("connection failed: " . $conn->connect_error);
        } else {
            
            $this->connection = $conn;
        }
    }
    //getting database connection reference / identifier
    public function get_connection()
    {
        return $this->connection;
    }
    public function close_connection()
    {
        $this->connection->close();
    }
}
