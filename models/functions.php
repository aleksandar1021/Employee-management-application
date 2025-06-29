<?php

    include_once __DIR__ . "/../config/connection.php";

    function isAdmin(){
        return isset($_SESSION["user"]) && $_SESSION["user"]->id_role == 4;
    }

    function isLogged(){
        return isset($_SESSION["user"]);
    }

    function isLoggedUser(){
        if(!isset($_SESSION["user"])){
            header("Location: ?page=login");
        }
    }

    function redirect(){
        if(isset($_SESSION["user"])){
            if($_SESSION["user"]->id_role != 4){
                header("Location: ?page=home");
            }
        }else{
            header("Location: ?page=home");
        }
    }

    function getUser(){
        if(isset($_SESSION["user"])){
            return $_SESSION["user"];
        }else{
            return null;
        }
    }

    function getEmployed(){
        global $conn;
        $query = "
            SELECT 
                u.*, 
                r.name as position, 
                es.name AS employment_status, 
                s.firstname AS supervisor_firstname, 
                s.lastname AS supervisor_lastname
            FROM user u
            JOIN role r ON u.id_role = r.id_role
            JOIN employment_status es ON es.id_employment_status = u.id_employment_status
            LEFT JOIN user s ON u.supervisor_id = s.id_user
           
        ";
    
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    function getPositions(){
        global $conn;
        $query = "SELECT * FROM role";
        return $conn->query($query)->fetchAll();
    }
    
    function getEmploymentTypes(){
        global $conn;
        $query = "SELECT * FROM employment_status";
        return $conn->query($query)->fetchAll();
    }

    function existsInTable($conn, $table, $column, $value) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
        $stmt->execute([$value]);
        return $stmt->fetchColumn() > 0;
    }
    
    function isEmailUnique($conn, $email) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() == 0;
    }

    function isEmailTakenByAnotherUser($conn, $email, $currentUserId) {
        $email = trim(strtolower($email)); 
        $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE LOWER(email) = ? AND id_user != ?");
        $stmt->execute([$email, $currentUserId]);
    
        return $stmt->fetchColumn() > 0;
    }
    
    
    function old($name, $default = '') {
        global $old;
        return htmlspecialchars($old[$name] ?? $default);
    }

    function error($name) {
        global $errors;
        return isset($errors[$name]) ? "<div class='text-danger mt-1'>{$errors[$name]}</div>" : '';
    }

    function getTasks(){
        global $conn;
        $query = "SELECT * FROM tasks t JOIN user u ON u.id_user = t.id_user";
        return $conn->query($query)->fetchAll();
    }
    
    function getTasksByUserId(){
        global $conn;
        $id = $_SESSION['user']->id_user;
        $query = "SELECT *, t.created_at as date_of_create FROM tasks t JOIN user u ON u.id_user = t.id_user WHERE t.id_user = $id";
        return $conn->query($query)->fetchAll();
    }

    function findUserById($id){
        global $conn;
        $query = "SELECT * FROM user WHERE id_user = :id";
        $stmt = $conn -> prepare($query);
        $stmt -> bindParam(":id", $id);
        $stmt -> execute();
        return $stmt->fetch();
    }

    function getTaskById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE id_task = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function isFirstLogin(){
        global $conn;
        $user = getUser();
        //var_dump($user);
        if(isset($user)){
            if(!$user->is_active){
                header("Location: ?page=setPassword");
            }
        }
    }

    function taskExists($id_task) {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE id_task = :id_task");
        $stmt->bindParam(':id_task', $id_task);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    function isNotLoggedUser(){
        global $conn;
        $user = getUser();
        if($user->is_active){
            header("Location: ?page=home");
        }
    }

    function getMessages(){
        global $conn;
        $query = "SELECT * FROM contact c JOIN user u ON c.id_user = u.id_user";
        return $conn->query($query)->fetchAll();
    }

    function getStatisticForTasks($status){
        global $conn;
        $id = $_SESSION['user']->id_user;
        $query = "SELECT COUNT(*) FROM tasks WHERE id_status = :status AND id_user = $id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute(); 
        return $stmt->fetchColumn();
    }

    function generateUniqueId($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $uniqueId = '';
    
        for ($i = 0; $i < $length; $i++) {
            $uniqueId .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $uniqueId;
    }
    
?>