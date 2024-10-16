<?php
require('validate.php');
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'));

    $doctorId = mysqli_real_escape_string($con, $_POST['editDoctorFormId']);
    $userId = mysqli_real_escape_string($con, $_POST['editUserId']);
    $fname = test_input($_POST['editDoctorFN']);
    $lname = test_input($_POST['editDoctorLN']);
    $email = test_input($_POST['editDoctorEmail']);
    $phone = test_input($_POST['editDoctorPhone']);
    $clinicId = mysqli_real_escape_string($con, $_POST['editDoctorClinic']);

    $data = [];
    $response = 200;

    if($fname == ""){
        $response =500;
        $msg = "Please Enter Doctor First Name!";
    }
    else if(!validateName($fname)){
        $response =500;
        $msg = "Please Enter a Valid Fname!";
    }
    else if($lname == ""){
        $response =500;
        $msg = "Please Enter Doctor Last Name!";
    }else if(!validateName($lname)){
        $response =500;
        $msg = "Please Enter a Valid Lname!";
    }else if($email == ""){
        $response =500;
        $msg = "Please Enter Doctor Email!";
    }else if(!validateEmail($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $response =500;
        $msg = "Please Enter a Valid Email!";
    }else if($phone == ""){
        $response =500;
        $msg = "Please Enter Doctor Phone Number!";
    }else if(!validatePhone($phone)){
        $response =500;
        $msg = "Please Enter a Valid Phone Number!";
    }else if($clinicId == "" || $clinicId == "clinic"){
        $response =500;
        $msg = "Please Enter Doctor Speciality!";
    }
    else{

        $Email_check_query = "SELECT * FROM user WHERE email=? AND userId <> ?";
        $Email_check_query_run = mysqli_prepare($con, $Email_check_query);
        mysqli_stmt_bind_param($Email_check_query_run, "si", $email, $userId);
        mysqli_stmt_execute($Email_check_query_run);
        mysqli_stmt_store_result($Email_check_query_run);
        if (mysqli_stmt_num_rows($Email_check_query_run) > 0) {
            $response =500;
            $msg = "Email already exists!";
        }else {
            $phoneCheckQuery = "SELECT phoneNumber FROM patient WHERE phoneNumber = ? 
            UNION 
            SELECT phoneNumber FROM doctor WHERE phoneNumber = ? AND doctorId <> ?";

            $phoneCheckQueryRun = mysqli_prepare($con, $phoneCheckQuery);
            mysqli_stmt_bind_param($phoneCheckQueryRun, "iii", $phone, $phone, $doctorId);
            mysqli_stmt_execute($phoneCheckQueryRun);
            mysqli_stmt_store_result($phoneCheckQueryRun);

            if (mysqli_stmt_num_rows($phoneCheckQueryRun) > 0) {
                $response =500;
                $msg = "Phone already exists!";
            }

            mysqli_stmt_close($phoneCheckQueryRun);
        }

        if($response != 500)
        {
            $user_query = "UPDATE user SET Fname=? , Lname=? , email=? WHERE userId=? ";
            $user_query_run = mysqli_prepare($con, $user_query);
            mysqli_stmt_bind_param($user_query_run, "sssi", $fname, $lname, $email, $userId);
    
            if(mysqli_stmt_execute($user_query_run)){

                $doctor_query = "UPDATE doctor SET clinicId=? , phoneNumber=? WHERE doctorId=? ";
                $doctor_query_run = mysqli_prepare($con, $doctor_query);
                mysqli_stmt_bind_param($doctor_query_run, "iii", $clinicId, $phone, $doctorId);
    
                if(mysqli_stmt_execute($doctor_query_run))
                {
                    $response =200;
                    $msg ="Doctor Account Updated Successfully!";   
                    
                    $data["fname"] = $fname;
                    $data["lname"] = $lname;
                    $data["email"] = $email;
                    $data["phone"] = $phone;
                    $data["clinic"] = $clinicId;
                }else{  
                    $response =500;
                    $msg ="Something Went Wrong!";
                }

                mysqli_stmt_close($doctor_query_run);     
                
            }else{
                mysqli_close($con);
                $response =500;
                $msg ="Something Went Wrong!";
            }

            mysqli_stmt_close($user_query_run);
        }

        mysqli_stmt_close($Email_check_query_run);
        mysqli_close($con);

    }

    $data["response"] = $response;
    $data["message"] = $msg;
    echo json_encode($data);
}