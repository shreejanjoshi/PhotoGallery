<?php

class User{

    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;

    public static function find_all_users(){
        return self::find_this_query("SELECT * FROM users");
    }

    public static function find_user_by_id($user_id){
        //datbase class last code that is this database---- methode from another
        global $database;

        //find this sql will pass query
        $result_set = self::find_this_query("SELECT * FROM users WHERE id = $user_id LIMIT 1");
        $found_user = mysqli_fetch_array($result_set);
        return $found_user;
    }

    public static function find_this_query($sql){
        global $database;

        $result_set = $database->query($sql);
        return $result_set;
    }
}