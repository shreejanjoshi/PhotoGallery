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
        //empty array to put object
        $the_object_array = array();

        //fetch to get result
        while ($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = self::instantation($row);
        }
        return $the_object_array;
    }

    //value of the record comes from find user by if in admin content
    public static function instantation($the_record){
        //ref to this object its self
        $the_object = new self();

        // $the_object->id = $found_user['id'];
        // $the_object->username = $found_user['username'];
        // $the_object->password = $found_user['password'];
        // $the_object->first_name = $found_user['first_name'];
        // $the_object->last_name = $found_user['last_name'];

        //
        foreach($the_record as $the_attribute => $value) {

            if($the_object->has_the_attribute($the_attribute)){
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    //what we wanna find -> attribute of instantation function
    private function has_the_attribute($the_attribute){

        //return all prop even prative get object vars
        $object_property = get_object_vars($this);

        //find out if key exists build in function
        //if atttribute exitst in array $object prop then return true or false
        return array_key_exists($the_attribute, $object_property);
    }
}