<?php
session_start();

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../config/dbcon.php');

$sql = "SELECT `email` FROM `appointment`, `patient`, `user` WHERE appId = 1 AND
appointment.patientId = patient.patientId AND patient.userId = user.userId";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];

if(isset($_POST['del-btn'])){
    $appointmentId= $_POST['appId'];
    $update_query = "UPDATE `appointment` SET `status`='rejected' WHERE appId = $appointmentId";
    $res = mysqli_query($con,$update_query);
    if($res){
        echo "1";
        $mail = new PHPMailer();
        try {
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = "smtp.gmail.com"; // Define SMTP host
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->SMTPSecure = 'tls'; // Set type of encryption
            $mail->Port = 587; // Set port to connect SMTP
            $mail->Username = "healthhubcenter23@gmail.com"; // Set Gmail username
            $mail->Password = "clctytzjvtgjfhei"; // Set Gmail password

            //Email Composition
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Appointment Rejection";
            $mail->Body = <<<END
            "Dear Patient, We regret to inform you that your appointment has been rejected."
            END;
            //$mail->IsHTML(true);
            $mail->send();
            } catch (Exception $e) {
                echo "2";
            }
        } else{
            echo "2";
        }
} else if(isset($_POST['acc-btn'])){
    $appointmentId= $_POST['appId'];
    $update_query = "UPDATE `appointment` SET `status`='accepted' WHERE appId = $appointmentId";
    $res2 = mysqli_query($con,$update_query);
    if($res2){
        $mail = new PHPMailer();
        try {
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = "smtp.gmail.com"; // Define SMTP host
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->SMTPSecure = 'tls'; // Set type of encryption
            $mail->Port = 587; // Set port to connect SMTP
            $mail->Username = "healthhubcenter23@gmail.com"; // Set Gmail username
            $mail->Password = "clctytzjvtgjfhei"; // Set Gmail password

            //Email Composition
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Appointment Acception";
            $mail->Body = <<<END
            Dear Patient,
            
            Your appointment has been accepted.
            Please contact us if you have any questions.
            
            Sincerely,
            The Clinic
            END;
           // $mail->IsHTML(true);
            $mail->send();
            } catch (Exception $e) {
                //echo "2"; 
            }
        } else{
            //echo "2";
        }
}
?>
