# PhotoGallery
Building a Photo Gallery System with Oop Php

## My goal
My main goal from this project is to understand the flow of Oop in Php.
How database is connected, how to make data, get data and all the CRUD system.

I am really passionate in learning PHP so to grow more knowledge in Php I bought this course in Udemy.
[PHP OOP](https://www.udemy.com/course/oop-php-object-oriented-programing-with-project-1-course/)

## Features

* Here I will categorise the features in which each feature will be referenced to its php file where I used it:

    - [Code structure](#code-structure)
    - [Back end](#back-end)
    - [Front end](#Front-end)


### Code structure

* init.php file:

    - This files includes all my classes and interfaces, session, and other important files for the system and I included init.php file in the header file to be included all over the system.

* new_config.php file:
    
    - Here I defined all my __CONSTANTS__ like __DB__ connection constants, and __ROOT PATHS__ Constants. 

* Classes and interfaces:

    - As you know from the [Summary](#summary) my system is Object oriented based PHP code, so I will discuss breifly the classes I built.

      * Database class

        - Here I did use a Design pattern called singleton which means that the class can only create one object instance from it self and any other object created after the first one is just a reference to the first created object and it is useful in some cases when I only need one instance and here for our database connection we need only one connection to one database.

        - You can see the class feature functions from its interface.  
        
        ```php
       
       
          interface Database_interface{

            // Establish a DB Connection using mysqli object
            public function open_connection_db();

            // create one object within the class (singleton pattern)
            public static function get_instance();

            // return the db connection
            public function get_connection();

            // Making a Query
            public function query($sql);

            // escaping sql strings
            public function escape_string($string);

            // getting the already inserted id
            public function inserted_id();

            // getting affected rows from last operation
            public function affected_query();
        }

       
        ```
        
        
        
    * Session class
        
        - It is responsible for tracking loged in users.  
       
        ```php
        

        class Session{

            // get the session sign_is status
            public function is_signed_in();

            // set the first user login session by passing its object
            public function login($user);

            // unset the session and object properties to log out
            public function logout();

            // get a message and set a message if there is not 
            public function message($msg);

            // check at first begin of session obj decl. (__construct() function)
        private function check_message(){

            // check views by refreshing
            public function visitor_count();

        }

        
        ```

    * DB_object class
        
        - This is my __parent class__ for database table classes (__User__, __Photo__, __Comment__) 

            * Here I refacored a lot of functions to be generic and usable for all my table classes like CRUD functions and more (create_obj, properties, clean_properties, ... etc)
            
            Example:  
            
            ```php
            
            // create a new object
            public static function instantation($the_record){

                // create a new object
                $calling_class = get_called_class();
                $the_object = new $calling_class;

                // loop in class properties
                foreach($the_record as $the_attribute => $value) {

                    // check each $property if exists
                    if($the_object->has_the_attribute($the_attribute)){
                        $the_object->$the_attribute = $value;
                    }
                }
                return $the_object;
            }
            
            ```

            * I also used an array in each class to hold the table fields names   
            `$db_table_fields = array( /* table fields name */);`

            * and variable to hold the table name  
            `$db_table = /* table name */`

            * They help me to iterate through each class table fields by its table name and execute genric functions declared at the parent class.
            
            Example:  
            
            ```php
            
            // get class properties
            protected function properties(){
                //we will get all the properties back lastname, username , password
                $properties = array();

                foreach(static::$db_table_fields as $db_field){
                    //check proprty extis in this class
                    if(property_exists($this, $db_field)){
                        $properties[$db_field] = $this->$db_field;
                    }
                }
                return $properties;
            }

            // get class properties after escaping the string 
            protected function clean_properties(){
                global $database;

                $clean_properties = array();

                foreach ($this->properties() as $key => $value){
                    $clean_properties[$key]= $database->escape_string($value);
                }
                return $clean_properties;
            }
            
            ```

            

    * Paginator class

        - Here I created a class to control the pagination feature.  

        ```php
        
           interface Paginator_interface{
        
                // Next and Previous functions 
                public function next();

                public function previous();

                // Total Nr of Pages function
                public function page_total();

                // has_next() && has_previous() functions
                public function has_next();

                public function has_previous();

                // get the next number of photos for the next page
                public function offset();
            }

        
        ```


### Back end

> Here you will find the php functionalities related to the view.   

* __User side__

    - **Home page** `index.php`
    
        1. I added the photos stored in the server and have records in the DB in a fixed size using pages.
        2. The pages are numbers and Next, Previous Next button disappears at the last page and previous button disappears at the first page.
    
    - **Photo page** `photo.php`
        
        1. I will fetch the photo from th DB using its ID.
        2. show Photo information 
        
* __Admin side__

    - **Dashboard** `index.php`
    
        1. Show the Nr. of my gallery system classes like how many photos, users, comments I have, and nr of views based on the refreshing of the page.
        2. Pie charts show the difference between the approved and unapproved for (photos, users, comments).
        3. There is also a Pie chart which shows the number of photos related to the admin user who did upload these photos.

    - **Users Page** `users.php`
    
        1. There is selected options to select all or some and applay some functionalities on all selected users like change user role or delete them.
        2. Each user has a link for delete except the logged in user I prevented him fromdeleting him self.
        3. Each user without a photo I add a placeholder image instead.
       
    - **Upload** `upload.php`
        
            1. Here I allow to add empty photo but it will not be published untill it is completed.
        

    - **Photos Page** `photos.php`
    
        
        1. Here we can see photos and their id, name, size, file name and total comments
        2. I created a link for comments which take you to a file with the comments related to this photo.
        
    - **Edit Photo** `edit_photo.php`
    
        1. edit to change title, caption, alternate text and description

    - **Comments Page** `comments.php`
    
        1. can see all the comments
        
        
### Front end


       
* __Online APIs__

    - Text editor API (CKEditor) used in `edit_photo.php`, `upload.php` and the script is placed in the `header.php` 
    ```html

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>

    ```
    
    - Pie chart Google API used in the __Dashboard__ at admin side
    
    ```html
    <!-- Pie Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    ```


## Features of the Photo Project
* User as a class
* An upload page, using a module
* Pagination
* Bootstrap to make it responsive
* Photo as a class

## Course description
Total lecture time: 18 hours.

_"PHP is one of the best web programming 
languages in the world, and all 
the big important websites, like Google, Apple, Facebook, Yahoo, 
Wikipedia and many more, use it for their 
web applications."_

_"In this course we will level up your basic 
PHP, using it to build the 
back end and front end for a photo storage 
system."_