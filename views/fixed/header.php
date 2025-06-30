<?php 
  include "models/functions.php";
  isLoggedUser();
  isFirstLogin();
?>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee management application</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/loginStyle.css" />
  <link rel="icon" href="assets/images/web.png" type="image/png">

</head>
<body>
<header>
    <h1>Employee management application</h1>
    <nav>
      <a href="?page=home">Tasks</a>
      <a href="?page=account">Account</a>
      <a href="?page=contact">Contact</a>

      <?= isAdmin() ? '<a href="?page=admin">Admin Panel</a>' : '' ?>
      <?= isLogged() ? '<a href="models/logout.php">Logout</a>' : '' ?>

    </nav>
  </header>

  <?php
    echo('<h2 style="color:#3300FF;">' . getUser()-> firstname . " " . getUser()->lastname . '</h2>');
  ?>