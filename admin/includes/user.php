<?php

class User{

    public function find_all_users(){
        //datbase class last code that is this database---- methode from another
        global $database;

        $result_set = $database->query("SELECT * FROM users");
        return $result_set;

    }
}