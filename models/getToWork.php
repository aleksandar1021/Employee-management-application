<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";

    if (!isset($_SESSION['user'])) {
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Invalid request method.";
        exit;
    }
    $errors = [];
    $id_task = $_POST['id_task'];

    if (!taskExists($id_task)) {
        $_SESSION['error'] = "Invalid task ID.";
        exit;
    }
    try {
        $stmt = $conn->prepare("UPDATE tasks SET id_status = 'It has begun' WHERE id_task = :id");
        $stmt->bindParam(":id", $id_task);
        $stmt->execute();
    } catch (PDOException $e) {
        $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
        exit;
    }
?>
