<?php
require('../config/dbcon.php');
header('Content-type: application/json');
$did = $_GET['did'];
$p=1;
$query = "SELECT feedbackId,patientId,message FROM feedback WHERE doctorId=? AND published=?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ii", $did,$p);

mysqli_stmt_execute($stmt);


mysqli_stmt_bind_result($stmt,$feedbackId,$patientId, $message);

$data = array();
while (mysqli_stmt_fetch($stmt)) {
    $data[] = array( 'fid'=>$feedbackId,'pid'=> $patientId, 'message' => $message);
}


mysqli_stmt_close($stmt);


echo json_encode($data);
?>

