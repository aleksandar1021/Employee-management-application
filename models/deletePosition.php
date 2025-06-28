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
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    }

    if (!isset($_POST['id_position'])) {
        $_SESSION['error'] = "Invalid position ID.";
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    }

    $id_position = (int)$_POST['id_position'];

    try {
        $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM user WHERE id_role = ?");
        $stmtCheck->execute([$id_position]);
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "This position is assigned to one or more users and cannot be deleted.";
            header("Location: ../index.php?page=admin&adminPage=positions");
            exit;
        }

        $stmtDelete = $conn->prepare("DELETE FROM role WHERE id_role = ?");
        $stmtDelete->execute([$id_position]);

        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    }
?>