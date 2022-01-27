<?php

class User extends DB_object{

    protected static $db_table = 'users';
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;

    public static function verify_user($username, $password){
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " .self::$db_table. " WHERE ";
        $sql .= "username = '{$username}' AND password = '{$password}' LIMIT 1";

        //find this sql will pass query
        $the_result_array = self::find_this_query($sql);

        //if this is not empty We do array shifts. So we get the first result of that array.
        //?->do this :->else
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    protected function properties(){
        //we will get all the properties back lastname, username , password
        $properties = array();

        foreach(self::$db_table_fields as $db_field){
            //check proprty extis in this class
            if(property_exists($this, $db_field)){
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties(){
        global $database;

        $clean_properties = array();

        foreach ($this->properties() as $key => $value){
            $clean_properties[$key]= $database->escape_string($value);
        }
        return $clean_properties;
    }

    public function save(){
         return isset($this->id) ? $this->update() : $this->create();
    }

//create CRUD
    public function create(){
        global $database;

        $properties = $this->clean_properties();

        //implode seprate the value ______________ array keys to pull out the keys of that array key -> username , password...
        $sql = "INSERT INTO " .self::$db_table. " (". implode(",", array_keys($properties)).")";
        $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";

        if($database->query($sql)){
            //pull the id out and store it in id
            $this->id = $database->the_insert_id();
            return true;
        }else{
            return false;
        }
    }

    public function update(){
        global $database;

        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach($properties as $key => $value){
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . self::$db_table . " SET ";
        //escpaing string before submiting
        $sql .= implode(",", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        //build in function
        //Gets the number of affected rows in a previous MySQL operation Returns the number of rows affected by the last INSERT, UPDATE, REPLACE or DELETE query.
        //For SELECT statements mysqli_affected_rows() works like mysqli_num_rows().
        //if the row is affected, and in our case we want to affect only one row, it should be 1.
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public function delete(){
        global $database;

        $sql = "DELETE FROM " . self::$db_table . " WHERE id=". $database->escape_string($this->id) . " LIMIT 1";

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }
}


