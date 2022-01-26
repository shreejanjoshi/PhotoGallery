
<?php require_once('init.php'); ?>

<?php
$session = new Session();
if($session->is_signed_in()){
    redirect('index.php');
}

//form
if(isset($_POST['submit'])){
    //clean updata that is comming
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //methode to check database user

    if($user_found){
        //inside session class
        $session->login($user_found);
        redirect("index.php");
    }else{
        $the_message = "Your password or username is incorrect";
    }
}else{//if user dont type anything
    $username = "";
    $password = "";
}
