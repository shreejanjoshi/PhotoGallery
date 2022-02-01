<?php

require_once("new_config.php");

class Database{

    //craete function
    public $connection;
    public $db;

    function __construct(){
        $this->db = $this->open_db_connection();
    }

    public function open_db_connection(){

        //$this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //new sqli and added in connection
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if($this->connection->connect_errno){
            die("Database connection failed ". $this->connection->connect_error);
        }

        return $this->connection;
    }

    public function query($sql){
        $result = $this->db->query($sql);
        $this->confirm_query($result);
        return $result;
    }

    //helper methode

    private function confirm_query($result){
        if(!$result){
            die("Query Failed ". $this->db->error);
        }
    }

    //escape string from , when we wanna put data in out database
    //clean up data santitise
    public function escape_string($string){
        return $this->connection->real_escape_string($string);
    }

    public function the_insert_id(){
        //return mysqli_insert_id($this->connection);
        return $this->db->insert_id;
    }
}


$database = new Database();

?>

