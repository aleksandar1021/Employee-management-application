<?php

    include "views/fixed/adminHeader.php";

    if(isset($_GET["page"]) && isset($_GET["adminPage"]) && $_GET["page"] == "admin"){
                
        if(in_array($_GET["adminPage"], adminPages)){
            include "views/pages/admin/" . $_GET["adminPage"] . ".php";
        }
        else{
            include "views/pages/admin/users.php";
        }
    }
    else{
        include "views/pages/admin/users.php";
    }


    include "views/fixed/adminFooter.php";

?>
