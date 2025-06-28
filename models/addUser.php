<?php
session_start();
include "../config/connection.php";
include "./functions.php";


$errors = [];
$old = [];

$nameRegex = '/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,29}$/u';
$addressRegex = '/^[A-Za-z0-9\s\.\-]{3,50}$/u';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $val) {
        $old[$key] = trim($val);
    }

    if (!preg_match($nameRegex, $old['firstname'])) {
        $errors['firstname'] = "First name must start with a capital letter and be 3–30 characters long.";
    }

    if (!preg_match($nameRegex, $old['lastname'])) {
        $errors['lastname'] = "Last name must start with a capital letter and be 3–30 characters long.";
    }

    if (!preg_match('/^\d{13}$/', $old['jmbg'])) {
        $errors['jmbg'] = "JMBG must contain exactly 13 digits.";
    }

    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    } elseif (!isEmailUnique($conn, $old['email'])) {
        $errors['email'] = "Email is already in use.";
    }

    if (!preg_match($addressRegex, $old['address'])) {
        $errors['address'] = "Address must be between 3 and 50 characters.";
    }

    if (!existsInTable($conn, 'role', 'id_role', $old['position'])) {
        $errors['position'] = "Selected position does not exist.";
    }

    if (!existsInTable($conn, 'employment_status', 'id_employment_status', $old['employment_status'])) {
        $errors['employment_status'] = "Employment status does not exist.";
    }

    if ((int)$old['supervisor'] > 0 && !existsInTable($conn, 'user', 'id_user', $old['supervisor'])) {
        $errors['supervisor'] = "Supervisor user does not exist.";
    }

    if (empty($old['employment_date']) || $old['employment_date'] < date('Y-m-d')) {
        $errors['employment_date'] = "Employment date must be today or in the future.";
    }

    if (empty($old['pwd']) || strlen($old['pwd']) < 8) {
        $errors['pwd'] = "Password must be at least 8 characters long.";
    }

    if (count($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $old;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO user (
                firstname, lastname, jmbg, email, address, id_role, 
                employment_date, supervisor_id, id_employment_status, password, is_active, created_at
            ) VALUES (
                :firstname, :lastname, :jmbg, :email, :address, :position, 
                :emp_date, :supervisor_id, :emp_status, :pwd, 0, NOW()
            )");

        $hashedPassword = sha1($old['pwd']); 

        $stmt->bindParam(':firstname', $old['firstname']);
        $stmt->bindParam(':lastname', $old['lastname']);
        $stmt->bindParam(':jmbg', $old['jmbg']);
        $stmt->bindParam(':email', $old['email']);
        $stmt->bindParam(':address', $old['address']);
        $stmt->bindParam(':position', $old['position'], PDO::PARAM_INT);
        $stmt->bindParam(':emp_date', $old['employment_date']);
        $supervisor = $old['supervisor'] ?: null;
        $stmt->bindParam(':supervisor_id', $supervisor, PDO::PARAM_INT);
        $stmt->bindParam(':emp_status', $old['employment_status'], PDO::PARAM_INT);
        $stmt->bindParam(':pwd', $hashedPassword);

        $stmt->execute();

        unset($_SESSION['old']);
        header("Location: ../index.php?page=admin&adminPage=users");
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
        $_SESSION['old'] = $old;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
