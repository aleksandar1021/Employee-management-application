<?php
    session_start();
    require_once '../config/connection.php';

    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo "Unauthorized";
        exit;
    }

    $userId = $_SESSION['user']->id_user;
    $password = $_POST['password'] ?? '';
    $rePassword = $_POST['rePassword'] ?? '';
    $errors = [];

    $updatePassword = false;

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters.";
        } elseif ($password !== $rePassword) {
            $errors[] = "Passwords do not match.";
        } else {
            $updatePassword = true;
        }
    }

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            $errors[] = "Image must be JPG, JPEG, or PNG.";
        }

        if ($file['size'] > $maxSize) {
            $errors[] = "Image must be smaller than 2MB.";
        }

        if (empty($errors)) {
            $uploadDir = "../assets/images/users/";
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = "user_" . $userId . "_" . time() . "." . $extension;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $imagePath = "assets/images/users/" . $newFileName;
                $_SESSION['user']->user_image =  $imagePath;
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../index.php?page=account");
        exit;
    }

    try {
        if ($updatePassword && $imagePath) {
            $stmt = $conn->prepare("UPDATE user SET password = :password, user_image = :image WHERE id_user = :id");
            $hashedPassword = sha1($password);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':image', $imagePath);
            $stmt->bindParam(':id', $userId);
        } elseif ($updatePassword) {
            $stmt = $conn->prepare("UPDATE user SET password = :password WHERE id_user = :id");
            $hashedPassword = sha1($password);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $userId);
        } elseif ($imagePath) {
            $stmt = $conn->prepare("UPDATE user SET user_image = :image WHERE id_user = :id");
            $stmt->bindParam(':image', $imagePath);
            $stmt->bindParam(':id', $userId);
        }

        if (isset($stmt)) {
            $stmt->execute();
            $_SESSION['success'] = "Your account has been updated.";
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = ["Database error: " . $e->getMessage()];
    }

    header("Location: ../index.php?page=account");
    exit;
?>
