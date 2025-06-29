<?php
    session_start();
    include "../config/connection.php";
    include "./sendEmail.php";
    include "./functions.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); 
        exit;
    }

    if (!isset($_SESSION['user'])) {
        http_response_code(401); 
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (strlen($title) < 4 || strlen($message) < 4) {
        http_response_code(422); 
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO contact (id_user, title, message) VALUES (:id_user, :title, :message)");
        $stmt->bindParam(':id_user', $_SESSION['user']->id_user);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        $user = getUserById($_SESSION['user']->id_user);

        $message = "Respected aleksa_kandic@yahoo.com,\r\n\r\n" .
           "You have new message from $user->firstname $user->lastname:\r\n\r\n" .
           "Title: $title\r\n" .
           "Message: $message\r\n";


        sendMail("aleksa_kandic@yahoo.com", "New message", $message);

        http_response_code(200);
    } catch (PDOException $e) {
        http_response_code(500); 
    }
?>