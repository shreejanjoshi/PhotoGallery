<?php
class Comment extends DB_object{

    protected static $db_table = 'comments';
    protected static $db_table_fields = array('id', 'photo_id', 'author', 'body');
    public $id;
    public $photo_id;
    public $author;
    public $body;

    // because we can implement additional code logic and checks, in that way we encompass everything related to the creation of the comment inside one method, once all the checks are passed, you can call the create method in order to create the recor
    //default value
    public static function create_comment($photo_id, $author="John", $body="") {
        //if not empty
        if(!empty($photo_id) && !empty($author) && !empty($body)){
            $comment = new Comment();

            $comment->photo_id = (int)$photo_id;
            $comment->author = $author;
            $comment->body = $body;

            return $comment;
        }else{
            //if empty
            return false;
        }
    }

    //finding speciefk photo in comments
    public static function find_the_comments($photo_id=0){
        global $database;

        $sql ="SELECT * FROM ". self::$db_table ." WHERE photo_id =" . $database->escape_string($photo_id) . " ORDER BY photo_id ASC";

        return self::find_by_query($sql);
    }
}


