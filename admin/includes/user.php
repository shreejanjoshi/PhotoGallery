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
        $the_result_array = self::find_by_query($sql);

        //if this is not empty We do array shifts. So we get the first result of that array.
        //?->do this :->else
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }


}


