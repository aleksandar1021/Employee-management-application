<?php 
    @session_start();
    
    include("const/const.php");
    if(isset($_GET["page"])){
        if ($_GET["page"] != "login" && $_GET["page"] != "register" && $_GET["page"] != "admin" && $_GET["page"] != "setPassword"){
            include("views/fixed/header.php");
        }
    }
    else{
         include("views/fixed/header.php");
    }

    
    if(isset($_GET["page"])){
                
        if(in_array($_GET["page"], pages)){
            include "views/pages/" . $_GET["page"] . ".php";
        }
        else{
            include "views/pages/home.php";
        }
    }
    else{
        include "views/pages/home.php";
    }

    if(isset($_GET["page"])){
        if($_GET["page"] != "login" && $_GET["page"] != "register" && $_GET["page"] != "admin" && $_GET["page"] != "setPassword"){
            include("views/fixed/footer.php");
        }
    }
    else{
         include("views/fixed/footer.php");
    }
    
?>