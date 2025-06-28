<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Invalid request method.";
        header("Location: ../index.php?page=admin&adminPage=messages");
        exit;
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']->id_role != 4) {
        $_SESSION['error'] = "Access denied.";
        header("Location: ../index.php?page=admin&adminPage=messages");
        exit;
    }

    if (!isset($_POST['id_contact'])) {
        $_SESSION['error'] = "Invalid position ID.";
        header("Location: ../index.php?page=admin&adminPage=messages");
        exit;
    }

    $id_contact = (int)$_POST['id_contact'];

    try {
        $stmtDelete = $conn->prepare("DELETE FROM contact WHERE id_contact = ?");
        $stmtDelete->execute([$id_contact]);

        header("Location: ../index.php?page=admin&adminPage=messages");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: ../index.php?page=admin&adminPage=messages");
        exit;
    }
?>