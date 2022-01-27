<?php include("includes/init.php"); ?>

<?php
//if user is login is false
//indide the function.php
if(!$session->is_signed_in()){ redirect("login.php");}

?>

<?php
    echo "it works";
?>