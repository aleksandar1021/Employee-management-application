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

        $id = (int)$old['id_user'];

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
        } elseif (isEmailTakenByAnotherUser($conn, $old['email'], $id)) {
            $errors['email'] = "Email is already in use by another user.";
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

    
        $supervisorRaw = $old['supervisor'] ?? null;
        $supervisor = null;
        
        if ($supervisorRaw !== '-1' && $supervisorRaw !== -1 && $supervisorRaw !== '' && $supervisorRaw !== null) {
            if ((int)$supervisorRaw === 0) {
                $supervisor = null;
            } else {
                $supervisor = (int)$supervisorRaw;
                if (!existsInTable($conn, 'user', 'id_user', $supervisor)) {
                    $errors['supervisor'] = "Supervisor user does not exist.";
                }
            }
        } else {
            $supervisor = null;
        }

        if (empty($old['employment_date'])) {
            $errors['employment_date'] = "Employment date is required.";
        }

        if (count($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $old;
            header("Location: ../index.php?page=admin&adminPage=editUser&id=" . $id);
            exit;
        }

        try {
            $sql = "
                UPDATE user SET
                    firstname = :firstname,
                    lastname = :lastname,
                    jmbg = :jmbg,
                    email = :email,
                    address = :address,
                    id_role = :position,
                    employment_date = :emp_date,
                    supervisor_id = :supervisor_id,
                    id_employment_status = :emp_status
                    WHERE id_user = :id_user";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':firstname', $old['firstname']);
            $stmt->bindParam(':lastname', $old['lastname']);
            $stmt->bindParam(':jmbg', $old['jmbg']);
            $stmt->bindParam(':email', $old['email']);
            $stmt->bindParam(':address', $old['address']);
            $stmt->bindParam(':position', $old['position'], PDO::PARAM_INT);
            $stmt->bindParam(':emp_date', $old['employment_date']);
            
            if (is_null($supervisor)) {
                $stmt->bindValue(':supervisor_id', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':supervisor_id', $supervisor, PDO::PARAM_INT);
            }
            
            $stmt->bindParam(':emp_status', $old['employment_status'], PDO::PARAM_INT);
            $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);

            $stmt->execute();

            unset($_SESSION['old']);
            header("Location: ../index.php?page=admin&adminPage=users");
            exit;
        } catch (PDOException $e) {
            $_SESSION['errors']['general'] = "Database error: " . $e->getMessage();
            $_SESSION['old'] = $old;
            header("Location: ../index.php?page=admin&adminPage=editUser&id=" . $id);
            exit;
        }
}
