<?php
session_start();
$userId = $_SESSION['auth_user']['user_id'];
include('../config/dbcon.php');
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'));

    $updateFname     = $_POST['First-Name'];
    $updateLname     = $_POST['Last-Name'];
    $updateEmail     = $_POST['pat-email'];
    if($_POST['phone'] == ""){
        $updatePhone     = null;
    }else{
        $updatePhone     = $_POST['phone'];
    }
    $updateDate      = $_POST['date'];
    $updateGender    = $_POST['gender'];
    $updateBloodType = $_POST['mySelect'];

    $data = [];

    if(empty($updateFname) || empty($updateLname) || empty($updateEmail)) {
        $response ='200';
    }
    else{

        $query = "UPDATE user 
        JOIN patient ON user.userId = patient.userId
        SET user.Fname = ?, 
            user.Lname = ?, 
            user.email = ?, 
            patient.gender = ?, 
            patient.bloodType = ?, 
            patient.dateOfBirth = ?,
            patient.phoneNumber = ?
        WHERE user.userId = ?";

        $query_run = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($query_run, "ssssssii", $updateFname, $updateLname, $updateEmail, $updateGender, $updateBloodType, $updateDate, $updatePhone, $userId);

        if(mysqli_stmt_execute($query_run))
        {
            $response ='500';
        }else{
            $response = '100';
        }

        mysqli_stmt_close($query_run);
        mysqli_close($con);

    }

    $data["response"] = $response;
    echo json_encode($data);
}