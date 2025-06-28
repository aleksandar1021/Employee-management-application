<?php
session_start();
include "../config/connection.php";

function getUser(){
    return $_SESSION["user"];
}

if(isset($_POST["password"]) && isset($_POST["rePassword"])){
    $password = $_POST['password'];
    $rePassword = $_POST['rePassword'];

    $errors = [];

    if(strlen($password) < 8){
        $errors["errorPassword"] = "Password must be at least 8 characters long.<br/>";
    }

    if($password != $rePassword){
        $errors["errorPassword"] = "Passwords must match.<br/>";
    }

    $user = getUser();
    $hashPassword = sha1($password);

    if($user->password === $hashPassword){
        $errors["errorPassword"] = "The password must be different from the one assigned to you by the administrator.<br/>";
    }

    if(!empty($errors)) {
        echo $errors["errorPassword"];
        http_response_code(400); 
        exit;
    }

    try {
        $user_id = $user->id_user;

        $query = "UPDATE user SET is_active = 1, password = :password WHERE id_user = :id_user";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":password", $hashPassword);
        $stmt->bindParam(":id_user", $user_id, PDO::PARAM_INT);

        if($stmt->execute()){
            http_response_code(204); 
            //header("Location: ../index.php?page=home");
            $_SESSION['user']->is_active = 1;
            exit;
        } else {
            http_response_code(500); 
            echo "Database update failed.";
            exit;
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Database error: " . $e->getMessage();
        exit;
    }
}
?>
