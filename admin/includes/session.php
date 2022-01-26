<?php

class Session{

    private $signed_in = false;
    public $user_id;

    function __construct(){
        session_start();
        $this->check_the_login();
    }

    //getter
    public function is_signed_in(){
        return $this->signed_in;
    }

    //login get user info if user is there or not true or false
    //user is comming from dtata base
    public function login($user){
        if($user){
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
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
}

$session = new Session();