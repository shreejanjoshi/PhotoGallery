<?php

class User{

    public static function find_all_users(){
        //datbase class last code that is this database---- methode from another
        global $database;

        $result_set = $database->query("SELECT * FROM users");
        return $result_set;
    }
}