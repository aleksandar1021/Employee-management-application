<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Invalid request method.";
        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']->id_role != 4) {
        $_SESSION['error'] = "Access denied.";
        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    }

    if (!isset($_POST['id_status'])) {
        $_SESSION['error'] = "Invalid status ID.";
        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    }

    $id_status = (int)$_POST['id_status'];

    try {
        $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM user WHERE id_employment_status = ?");
        $stmtCheck->execute([$id_status]);
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "This status is assigned to one or more users and cannot be deleted.";
            header("Location: ../index.php?page=admin&adminPage=employmentStatus");
            exit;
        }

        $stmtDelete = $conn->prepare("DELETE FROM employment_status WHERE id_employment_status = ?");
        $stmtDelete->execute([$id_status]);

        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    }
?>