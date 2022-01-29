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



    // This is passing $_FILES['uploaded_file'] as an argument
    public function set_file($file) {

        if(empty($file) || !$file || !is_array($file)) {

            $this->errors[] = "There was no file uploaded here";
            return false;

        }elseif($file['error'] !=0) {

            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;

        } else {

            //file name
            $this->user_image =  basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];

        }
    }

    public function save_user_and_image(){
            //if error is empty then we good
            if(!empty($this->errors)){
                return false;
            }

            if(empty($this->user_image) || empty($this->tmp_path)){
                $this->errors[] = "the file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

            //make we dont make same file
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->user_image} already exists";
                return false;
            }

            //move the file
            //take temp 2 para temp path and where is going parmate path
            if(move_uploaded_file($this->tmp_path, $target_path)) {

                //after we move this check this if create unset tem path
                if(	$this->create()) {

                    unset($this->tmp_path);
                    return true;
                }
            }else{
                //if mothing work
                $this->error[] = "The file directory probably does not have permission";
                return false;
            }
            $this->create();

    }


}


