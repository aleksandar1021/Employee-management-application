<?php
session_start();
include "../config/connection.php";

if (!isset($_SESSION['user']) || $_SESSION['user']->id_role != 4) {
    header("Location: ?page=home");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {
    $id = (int) $_POST['id_user'];
    try {
        $stmtUpdateSupervised = $conn->prepare("UPDATE user SET supervisor_id = NULL WHERE supervisor_id = :id_user");
        $stmtUpdateSupervised->bindParam(":id_user", $id);
        $stmtUpdateSupervised->execute();

        $stmtTasks = $conn->prepare("DELETE FROM tasks WHERE id_user = :id_user");
        $stmtTasks->bindParam(":id_user", $id);
        $stmtTasks->execute();

        $stmtUser = $conn->prepare("DELETE FROM user WHERE id_user = :id_user");
        $stmtUser->bindParam(":id_user", $id);
        $stmtUser->execute();

        header("Location: ../index.php?page=admin&adminPage=users");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php?page=admin&adminPage=users");
    exit;
}
?>
