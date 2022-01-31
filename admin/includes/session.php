<?php

class Session{

    private $signed_in = false;
    public $user_id;
    public $message;

    //dashborad view
    public $count;

    function __construct(){
        session_start();
        $this->check_the_login();
        $this->check_message();

        //dashborad view
        $this->visitor_count();
    }

    public function message($msg=""){
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        }else{
            return $this->message;
        }
    }

    private function check_message(){

        if(isset($_SESSION['message'])) {

            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);

        } else {

            $this->message = "";
        }


    }

    //getter
    public function is_signed_in() {

		return $this->signed_in;
	}

    //login get user info if user is there or not true or false
    //user is comming from dtata base
    public function login($user) {

        if($user) {
            // $user->id value is being assigned to $_SESSION['user_id'] and also assigned to $this->user_id --- both have same value
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    
    
        }

    //logout function
    public function logout() {

        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    private function check_the_login(){
        //if user come and it found out user is their
        if (isset($_SESSION['user_id'])) {

            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;


        } else {

            unset($this->user_id);
            $this->signed_in = false;

        }
    }


    //dashbord view
    public function visitor_count() {
        if(isset($_SESSION['count'])) {
            //if set add
                return $this->count = $_SESSION['count']++;
        }else{
            //if some reason didnt set set 1
                return $_SESSION['count'] = 1;
        }
    }
       
       

}
       

$session = new Session();

?>