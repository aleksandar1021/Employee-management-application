<?php 
    @session_start();
    include("../config/connection.php");

    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST["email"];
        $password = $_POST["password"];
      
        $query = "SELECT * FROM user u JOIN role r ON u.id_role = r.id_role where email = :email";
        $stmt = $conn -> prepare($query);
        $stmt -> bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch();

        $passwordCrypt = sha1($password);

        //echo($passwordCrypt);

        if(!$result) {
            $error = "Wrong credentials.";
            echo($error);
            http_response_code(401);
        } else {
            if($result->password != $passwordCrypt) {
                $error = "Wrong credentials.";
                echo($error);
                http_response_code(401);
            }else{
                $_SESSION['user'] = $result;
                http_response_code(200);
            } 
        }
        
    }

?>