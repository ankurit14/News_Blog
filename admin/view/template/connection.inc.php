<?php
class dbConnector {
    private $serverName = "localhost";
    private $dbName = "tishha";
    private $userName = "root";
    private $password = "";
    private $conn;

    public function __construct(){
        $this->conn = $this->connect();
    }
    public function connect(){
        $db = new PDO("mysql:host=$this->servername;dbname=$this->dbname",$this->username,$this->password);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // session_start();
        return $db;
      }

}
?>