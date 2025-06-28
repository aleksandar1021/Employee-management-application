<?php 
    @session_start();
    if(isset($_SESSION["user"])){
        session_destroy();
        header("Location: ../index.php?page=login");
    }else{
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
?>