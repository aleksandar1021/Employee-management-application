<?php
    include "../config/connection.php";
    session_start();

    header('Content-Type: application/json');

    if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id_user)) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $userId = $_SESSION['user']->id_user;

    $where = ["t.id_user = :user_id"];
    $params = [':user_id' => $userId];

    if (!empty($_GET['status'])) {
        $where[] = "t.id_status = :status";
        $params[':status'] = $_GET['status'];
    }

    if (!empty($_GET['priority'])) {
        $where[] = "t.priority = :priority";
        $params[':priority'] = $_GET['priority'];
    }

    if (!empty($_GET['search'])) {
        $where[] = "t.title LIKE :search OR t.name LIKE :search";
        $params[':search'] = "%" . $_GET['search'] . "%";
    }

    $sql = "SELECT 
                t.*, 
                u.firstname AS assigned_firstname, 
                u.lastname AS assigned_lastname,
                issuer.firstname AS issuer_firstname,
                issuer.lastname AS issuer_lastname
            FROM tasks t
            JOIN user u ON u.id_user = t.id_user
            JOIN user issuer ON issuer.id_user = t.issued_by";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    if (!empty($_GET['sort'])) {
        $sort = strtolower($_GET['sort']) === 'desc' ? 'DESC' : 'ASC';
        $sql .= " ORDER BY t.due_date $sort";
    }

    try {
        $stmt = $conn->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();

        $tasks = $stmt->fetchAll(); 
        echo json_encode($tasks);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Server error occurred.']);
    }
?>
