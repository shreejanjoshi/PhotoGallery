<?php include("includes/init.php"); ?>

<?php
//if comment is login is false
//indide the function.php
if(!$session->is_signed_in()){ redirect("login.php");}

?>

<?php

if(empty($_GET['id'])){
    redirect("comment.php");
}

$comment = Comment::find_by_id($_GET['id']);

if($comment){
    $comment->delete();
    redirect("comments.php");
}else{
    redirect("comments.php");
}
?>
