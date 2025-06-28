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
        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    }

    $errors = [];
    $old = [];

    $id_status = $_POST['id_status'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $old['name'] = $name;
    $old['id_status'] = $id_status;

    if (!$id_status || !is_numeric($id_status)) {
        $_SESSION['error'] = "Invalid employment status ID.";
        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;
    }

    $regex = '/^[A-ZŠĐŽČĆ][a-zA-ZšđžčćŠĐŽČĆ\s]{2,49}$/u';
    if (!preg_match($regex, $name)) {
        $errors['name'] = "Name must start with a capital letter and be 3–50 characters long.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=editEmploymentStatus&id=" . $id_status);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE employment_status SET name = :name WHERE id_employment_status = :id");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":id", $id_status, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../index.php?page=admin&adminPage=employmentStatus");
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=editPosition&id=" . $id_status);
        exit;
    }
?>
