<?php

class Photo extends DB_object{

    protected static $db_table = 'photos';
    protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size', 'user_id');
    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;
    public $user_id;

    //temp path for img help us to move in perm path
    public $tmp_path;
    public $upload_directory = "images";


    //dynamic even if file name does not effect
    public function picture_path(){
        return $this->upload_directory.DS.$this->filename;
    }

    public function save(){
        if($this->id){
            $this->update();
        }else{
            //if error is empty then we good
            if(!empty($this->errors)){
                return false;
            }

            if(empty($this->filename) || empty($this->tmp_path)){
                $this->errors[] = "the file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

            //make we dont make same file
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists";
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

    //delete data from datbase and also from server
    public function delete_photo(){
        if($this->delete()){
            $target_path = SITE_ROOT .DS. 'admin' .DS. $this->picture_path();
            return unlink($target_path) ? true : false;
        }else{
            return false;
        }
    }
}
