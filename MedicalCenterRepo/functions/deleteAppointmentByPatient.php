<?php
    header('Content-type: application/json');
    $response = "";
    $data     = [];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $json = json_decode(file_get_contents('php://input'));
        $id = trim($json->id);
        include('../config/dbcon.php');
        $query = 'DELETE FROM appointment WHERE appointment.appId = ?';
        $stmt  = mysqli_prepare($con, $query);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            $id = trim($json->id);
            if(mysqli_stmt_execute($stmt)) {
                echo json_encode("deleted");
                $response = '200';
            }
            else{
                echo json_encode("could not delete from database");
                $response = '300';
            }
        } 
        else {
            die("Error in prepared statement: " . mysqli_error($con));
        }
    }
    $data["response"] = $response;
?>