<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Invalid request method.";
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']->id_role != 4) {
        $_SESSION['error'] = "Access denied.";
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    }

    if (!isset($_POST['id_task'])) {
        $_SESSION['error'] = "Invalid task ID.";
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    }

    $id_task = (int)$_POST['id_task'];

    try {
        $query = "SELECT * FROM tasks WHERE id_task = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_task]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        $image = "../".$task['image'];
        if (file_exists($image)) {
            unlink($image);
        }

        $stmtDelete = $conn->prepare("DELETE FROM tasks WHERE id_task = ?");
        $stmtDelete->execute([$id_task]);

        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    }
?>