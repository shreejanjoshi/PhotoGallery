<?php

class User{

    protected static $db_table = 'users';
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;

    //what we do here is find this query, we can find that function under
    public static function find_all_users(){
        return self::find_this_query("SELECT * FROM users");
    }

    public static function find_user_by_id($user_id){
        //datbase class last code that is this database---- methode from another
        global $database;

        //find this sql will pass query
        $the_result_array = self::find_this_query("SELECT * FROM users WHERE id = $user_id LIMIT 1");

        //if this is not empty We do array shifts. So we get the first result of that array.
        //?->do this :->else
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    //We create an array here to save some of the objects that are coming through because we using these instantiation.
    //while loop to fetch that data base, that table we get that we set. result set to row. now we get tablein row
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

    public static function verify_user($username, $password){
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' AND password = '{$password}' LIMIT 1";

        //find this sql will pass query
        $the_result_array = self::find_this_query($sql);

        //if this is not empty We do array shifts. So we get the first result of that array.
        //?->do this :->else
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    //value of the record comes from find this qiuery by if in admin content
    public static function instantation($the_record){
        //ref to this object its self
        $the_object = new self();

        // $the_object->id = $found_user['id'];
        // $the_object->username = $found_user['username'];
        // $the_object->password = $found_user['password'];
        // $the_object->first_name = $found_user['first_name'];
        // $the_object->last_name = $found_user['last_name'];

        //loop throught the table
        foreach($the_record as $the_attribute => $value) {

            if($the_object->has_the_attribute($the_attribute)){
                //value is username , firstname
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

    // User::find_all()  ... Here is the flow once is called

// 1.   It goes to the find_all method

// 2. The find_all() returns the find_by_query() results

// 3. The find_by_query()  does a couple things

//        1. it makes the query

//         2. Fetches the the data from database table using  a while loop and it returns it in $row

//         3. Passes the results ($row) to the Instantiation (instantantion - weird name I know) method

//         4. Returns the object in the $the_object_array variable that it gets from the  instantantion method.

// 5. And that will be the result that find_all() returns when we use User::find_all()



//   What the Instantation method is doing

//    1. Gets the calling class name.

//    2. Creates an instance of the class

//    3. It loops through the $the_record variable that has all the records

//    4. It checks to see if the properties exist on that object with the other method has_the_property()

//    5. If the keys from the record which basically are the columns from db table are found or equal the object properties then it assigns    the values to them.

// 6. Finally it returns the object!



// The purpose of this is to basically create our own API to deal with the database query so that in the future we can plug in other API's. Now there still a couple things I want to improve to make this way better, cleaner and more universal.

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


