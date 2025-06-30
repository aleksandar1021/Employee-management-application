<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require __DIR__ . '/../vendor/autoload.php'; 

    function sendMail($to, $subject, $messageBody) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bookatable12345@gmail.com';
            $mail->Password   = '';  // app-password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('bookatable12345@gmail.com', 'Employee managment app'); // isto kao Username
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body    = $messageBody;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
