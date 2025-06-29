<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";
    include "./sendEmail.php";

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
        $task = getTask($id_task);

        var_dump($task);
        $imagePath = "../" . $task->image; 

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $user = getUserById($task->id_user);

        $message = "Respected {$user->firstname} {$user->lastname},\r\n\r\n" .
                "Your task with name: {$task->name} has been deleted.";

        sendMail($user->email, "Deleted task", $message);

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