<?php
    session_start();
    include "../config/connection.php";
    include "./functions.php";
    include "./sendEmail.php";

    $errors = [];
    $old = [];

    $name = generateUniqueId();

    if (!isset($_SESSION['user']) || $_SESSION['user']->id_role != 4) {
        header("Location: ../index.php?page=home");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Invalid request method.";
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;
    }

    foreach ($_POST as $key => $val) {
        $old[$key] = trim($val);
    }

    $title = $old['title'] ?? '';
    $description = $old['description'] ?? '';
    $employed = $old['employed'] ?? '';
    $date_due = $old['date_due'] ?? '';
    $status = $old['status'] ?? '';
    $priority = $old['priority'] ?? '';

    $titleRegex = '/^[A1234567890-ZŠĐŽČĆ1234567890][a-z1234567890A-ZšđžčćŠĐŽČĆ1234567890\s]{2,99}$/u';
    $descRegex = '/^[A1234567890-ZŠĐŽČĆ1234567890][\sa1234567890-z1234567890A-ZšđžčćŠĐŽČĆ0-9.,!?]{2,499}$/u';

    if (!preg_match($titleRegex, $title)) {
        $errors['title'] = "Title must start with a capital letter and be 3–100 characters long.";
    }

    if (!preg_match($descRegex, $description)) {
        $errors['description'] = "Description must start with a capital letter and be 3–500 characters long.";
    }

    if (!$employed || !existsInTable($conn, 'user', 'id_user', $employed)) {
        $errors['employed'] = "You must select a valid employee.";
    }

    if (empty($date_due) || $date_due < date('Y-m-d')) {
        $errors['date_due'] = "Date must be today or in the future.";
    }

    if (!in_array($status, ['It has not started', 'It has begun', 'Done'])) {
        $errors['status'] = "Invalid status selected.";
    }

    if (!in_array($priority, ['Low', 'Normal', 'High', 'Critical'])) {
        $errors['priority'] = "Invalid priority selected.";
    }

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $errors['image'] = "Image upload failed.";
        } else {
            $imagePath = 'assets/images/' . $imageName;
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=addTask");
        exit;
    }

    try {
        $id_user = getUser()->id_user;

        $stmt = $conn->prepare("
            INSERT INTO tasks (id_user, title, description, due_date, id_status, priority, image, issued_by, name)
            VALUES (:id_user, :title, :description, :date_due, :status, :priority, :image, :issued_by, :name)
        ");

        $stmt->bindParam(":id_user", $employed, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":date_due", $date_due, PDO::PARAM_STR);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":priority", $priority, PDO::PARAM_STR);
        $stmt->bindParam(":image", $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(":issued_by", $id_user, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        $stmt->execute();

        $user = getUserById($employed);
        $issuer = getUserById($id_user);

        $message = "Respected {$user->firstname} {$user->lastname},\r\n\r\n" .
           "You have been assigned a new task with the following details:\r\n\r\n" .
           "Name: $name\r\n" .
           "Title: $title\r\n" .
           "Description: $description\r\n" .
           "Date Due: $date_due\r\n" .
           "Priority: $priority\r\n" .
           "Issued by: {$issuer->firstname} {$issuer->lastname}\r\n\r\n" .
           "Please complete it within the given time.\r\n\r\n" .
           "Best regards,\r\n" .
           "Task Management System";


        sendMail($user->email, "New task", $message);


        unset($_SESSION['old']);
        $_SESSION['success'] = "Task successfully created.";
        header("Location: ../index.php?page=admin&adminPage=tasks");
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
        $_SESSION['old'] = $old;
        header("Location: ../index.php?page=admin&adminPage=addTask");
        exit;
    }
?>