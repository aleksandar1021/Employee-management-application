<?php
        @session_start();
        include("../config/connection.php");

        if(isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])){
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $email = $_POST["email"];
                $password=$_POST['password'];

                $regexNameAndLastname = "/[A-Z][a-z]{2,30}$/";
                $errors =[];
           
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $errors["mejlGreska"] = "Email is not in good format, example: user@gmail.com<br/>";
                }
                if(!preg_match($regexNameAndLastname,$firstname)){
                        $errors["errorFirstname"]="the firstnamename must begin with a capital letter and have at least 3 characters.<br/>";
                }
                if(!preg_match($regexNameAndLastname,$lastname)){
                        $errors["errorLastname"]="the lastname must begin with a capital letter and have at least 3 characters.<br/>";
                }
                if(strlen($password)<8){
                        $errors["errorPassword"]="password must be at least 8 characters long.<br/>";
                }
                

                
                if(!$errors){
                    $query = "SELECT * FROM user WHERE email ='$email'";
                    $result = $conn->query($query)->fetch();
                    if($result){
                        $errors["errorUserExist"] = "User already exists with this email.";
                        echo $errors["errorUserExist"];
                    }
                    else{
                        $passwordCrypt = sha1($password);
                        $queryInsert = "INSERT INTO user(email, firstname, lastname, id_role, password) VALUES (:email,:firstname,:lastname,1,:passwordCrypt)";
                        $stmt = $conn->prepare($queryInsert);
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":firstname", $firstname);
                        $stmt->bindParam(":lastname", $lastname);
                        $stmt->bindParam(":passwordCrypt", $passwordCrypt);
                        $resultQuery = $stmt->execute();
                        if($resultQuery){
                            http_response_code(201);
                            echo "Successful registration, go to the page <a href='?page=login'>Login</a>";

                        }else{
                            http_response_code(400);
                        }
                    }

                }
                
                

        }
   

?>