<?php
require('../config/dbcon.php');

$did = $_POST['did'] ;
$date = $_POST['day'] ;
$time = $_POST['time'];
$status = 'pending';
//fi osset l patient id bde jiba mn l sessions

if (isset($_POST['time']) && $_POST['time'] !== "") {
    $query = "INSERT INTO appointment(doctorId, patientId, date, time, status) VALUES ('$did', '2', '$date', '$time', '$status')";
    // Execute the query here
    mysqli_query($con,$query);  
}
?>
