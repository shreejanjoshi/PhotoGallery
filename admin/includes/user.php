<?php

class User extends DB_object{

    protected static $db_table = 'users';
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/400x400&text=image";


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

    public function image_path_and_placeholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory. DS. $this->user_image;
    }


}


