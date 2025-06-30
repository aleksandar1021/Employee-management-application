<?php
    include "models/functions.php";
    //include "config/connection.php";

    redirect();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel</title>
    <link href="assets/admin/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/admin/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/admin/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/admin/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/admin/css/master.css" rel="stylesheet">
    <link rel="icon" href="assets/images/web.png" type="image/png">

</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header" style="color: black; font-size:30px; font-weight:900">
                Admin Panel
            </div>
            <ul class="list-unstyled components text-secondary">
                
                <li>
                    <a href="?page=admin&adminPage=users"><i class="fas fa-users"></i>Employed</a>
                </li>

                <li>
                    <a href="?page=admin&adminPage=positions"><i class="fas fa-suitcase"></i>Positions</a>
                </li>

                <li>
                    <a href="?page=admin&adminPage=employmentStatus"><i class="fas fa-network-wired"></i>Employment Status</a>
                </li>
                
                <li>
                    <a href="?page=admin&adminPage=tasks"><i class="fas fa-table"></i>Tasks</a>
                </li> 
                <li>
                    <a href="?page=admin&adminPage=messages"><i class="fas fa-sms"></i>Messages</a>
                </li> 
            </ul>
        </nav>
        <!-- end of sidebar component -->
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> &nbsp; <span><?= getUser()->firstname . " " . getUser()->lastname?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="models/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>