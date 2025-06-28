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

    $id_position = $_POST['id_position'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $old['name'] = $name;
    $old['id_position'] = $id_position;

    if (!$id_position || !is_numeric($id_position)) {
        $_SESSION['error'] = "Invalid position ID.";
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;
    }

    $regex = '/^[A-ZŠĐŽČĆ][a-zA-ZšđžčćŠĐŽČĆ\s]{2,49}$/u';
    if (!preg_match($regex, $name)) {
        $errors['name'] = "Name must start with a capital letter and be 3–50 characters long.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=editPosition&id=" . $id_position);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE role SET name = :name WHERE id_role = :id");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":id", $id_position, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = "Position successfully updated.";
        header("Location: ../index.php?page=admin&adminPage=positions");
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=editPosition&id=" . $id_position);
        exit;
    }
?>
