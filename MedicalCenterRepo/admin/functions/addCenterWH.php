<?php
require('validate.php');
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'));
    
    $day=test_input($_POST['WHDay']);
    $from= "";
    if(isset($_POST['WHFrom'])){
        $from=test_input($_POST['WHFrom']);
    }
    $to= "";
    if(isset($_POST['WHTO'])){
        $to=test_input($_POST['WHTO']);
    }
    $closed= isset($_POST['closed']) ? "1":"0";

    $data = [];
    
    if($day!= "" && $day!= "WHDay"){

        $check_query = "SELECT * FROM medicalHours WHERE day=?";
        $check_query_run = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_query_run, "s",$day);
        mysqli_stmt_execute($check_query_run);
        $check_result = mysqli_stmt_get_result($check_query_run);

        if(mysqli_num_rows($check_result) > 0){

            $update_query = "UPDATE medicalHours SET fromHour=? , toHour=?, closed=? WHERE day=? ";
            $update_query_run = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_query_run, "ssis", $from, $to, $closed,$day);
    
            if(mysqli_stmt_execute($update_query_run))
            {
                $response = 200;
                $msg ="Medical Hour Updated Successfully!";

                $data["day"] = $day;
                $data["from"] = $from;
                $data["to"] = $to;
                $data["closed"] = $closed;
        
            }else{
                $response = 500;
                $msg ="Something Went Wrong!";
            }

            mysqli_stmt_close($update_query_run);

        }else{

            $medicalHours_query = "INSERT INTO medicalHours (day, fromHour, toHour, closed) VALUES (?, ?, ?, ?)";
            $medicalHours_query_run = mysqli_prepare($con, $medicalHours_query);
            mysqli_stmt_bind_param($medicalHours_query_run, "sssi", $day, $from, $to, $closed);
    
            if(mysqli_stmt_execute($medicalHours_query_run))
            {
                $response = 200;
                $msg ="Medical Hour Added Successfully!";

                $data["day"] = $day;
                $data["from"] = $from;
                $data["to"] = $to;
                $data["closed"] = $closed;
        
            }else{
                $response = 500;
                $msg ="Something Went Wrong!";
            }

            mysqli_stmt_close($medicalHours_query_run);
        }

        mysqli_stmt_close($check_query_run);
        mysqli_close($con);
    }else{
        $response = 500;
        $msg ="Please Enter Working Day!";
    }

    $data["response"] = $response;
    $data["message"] = $msg;
    echo json_encode($data);
}