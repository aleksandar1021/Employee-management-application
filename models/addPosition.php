<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";

    if (!isset($_SESSION['user']) || $_SESSION['user']->id_role != 4) {
        header("Location: ../index.php?page=home");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Invalid request method.";
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    }

    $errors = [];
    $old = [];
    $name = trim($_POST['name'] ?? '');
    $old['name'] = $name;

    $regex = '/^[A-ZŠĐŽČĆ][a-zA-ZšđžčćŠĐŽČĆ\s]{2,49}$/u';
    if (!preg_match($regex, $name)) {
        $errors['name'] = "Name must start with a capital letter and be 3–50 characters long.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=addPosition");
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO role (name) VALUES (:name)");
        $stmt->bindParam(":name", $name);
        $stmt->execute();

        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=addPosition");
        exit;
    }
?>