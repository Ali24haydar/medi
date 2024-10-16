<?php

require 'C:\wamp64\www\MedicalCenter\config\dbcon.php';
require 'C:\wamp64\www\MedicalCenter\PHPMailer-master\src\Exception.php';
require 'C:\wamp64\www\MedicalCenter\PHPMailer-master\src\PHPMailer.php';
require 'C:\wamp64\www\MedicalCenter\PHPMailer-master\src\SMTP.php';

/* require '../../config/dbcon.php';
require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php'; */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Email configuration
$emailHost = 'smtp.gmail.com';
$emailPort = 587;
$emailUsername = 'healthhubcenter23@gmail.com';
$emailPassword = 'clctytzjvtgjfhei';

$data = [];

// Create a PHPMailer instance
$mail = new PHPMailer(true);

// SMTP configuration
$mail->isSMTP();
$mail->Host = $emailHost;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Port = $emailPort;
$mail->Username = $emailUsername;
$mail->Password = $emailPassword;

// Fetch upcoming appointments for the next day
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$stmt = $con->prepare("SELECT u.email, a.date, a.time FROM appointment a JOIN patient p ON a.patientId = p.patientId JOIN user u ON p.userId = u.userId WHERE a.date = ? AND a.status='accepted'");
$stmt->bind_param('s', $tomorrow);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);

$numRows = $result->num_rows;

if ($numRows > 0) {
    // Send confirmation emails
    foreach ($appointments as $appointment) {
        $email = $appointment['email'];
        $date = $appointment['date'];
        $time = $appointment['time'];

        try {
            // Email content
            $mail->setFrom($emailUsername);
            $mail->addAddress($email);
            $mail->Subject = 'Appointment Confirmation';
            $mail->Body = "Dear patient,\n\nThis is a reminder for your appointment scheduled for $date at $time.\n\nRegards,\nYour Clinic";

            // Send email
            $mail->send();

            $response = 200;
            $msg = "Email Sent Successfully!";
        } catch (Exception $e) {
            $response = 500;
            $msg = $e->getMessage();
        }
    }
} else {
    $response = 500;
    $msg = "No appointments for tomorrow!";
}

$data["response"] = $response;
$data["message"] = $msg;
echo json_encode($data);

// Close the database connection
$con->close();
?>