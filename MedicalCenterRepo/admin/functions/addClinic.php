<?php
require('validate.php');
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(file_get_contents('php://input'));

/*     $name=test_input($json->clinicName);
    $description=test_input($json->clinicDesc); */

    $name = test_input($_POST['clinicName']);
    $description = test_input($_POST['clinicDesc']);

    $image = $_FILES['clinicImg']['name'];
    $path="../../uploads";
    /* $image_ext =pathinfo($image,PATHINFO_EXTENSION); */
    $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $filename= time().'.'.$image_ext;

    $icon = $_FILES['clinicIcon']['name'];
    /* $icon_ext =pathinfo($icon,PATHINFO_EXTENSION); */
    $icon_ext = strtolower(pathinfo($icon, PATHINFO_EXTENSION));
    $filename2= time()+1 .'.'.$icon_ext;

    // Check if the file extension is allowed
    $allowed_extensions = array("jpg", "jpeg", "png");
    $data = [];

    if($name == ""){
        $response = 500;
        $msg= "Please Enter Clinic Name!";
    }else if(!validateName($name)){
        $response = 500;
        $msg= "Please Enter a Valid Name!";
    }else if($description == ""){
        $response = 500;
        $msg= "Please Enter Clinic Description!";
    }else if(!validateDesc($description)){
        $response = 500;
        $msg= "Please Enter a Valid  Description!";
    }else if($filename == ""){
        $response = 500;
        $msg= "Please Enter Clinic Image!";
    }else if (!in_array($image_ext, $allowed_extensions)) {
        $response = 500;
        $msg = "Invalid file extension for photo. Allowed extensions: " . implode(", ", $allowed_extensions);
    }else if($filename2 == ""){
        $response = 500;
        $msg= "Please Enter Clinic Icon!";
    }else if (!in_array($icon_ext, $allowed_extensions)) {
        $response = 500;
        $msg = "Invalid file extension for icon. Allowed extensions: " . implode(", ", $allowed_extensions);
    }
    else{
        $clinic_check_query = "SELECT * FROM clinic WHERE name=?";
        $clinic_check_query_run = mysqli_prepare($con, $clinic_check_query);
        mysqli_stmt_bind_param($clinic_check_query_run, "s", $name);
        mysqli_stmt_execute($clinic_check_query_run);
        mysqli_stmt_store_result($clinic_check_query_run);
        if (mysqli_stmt_num_rows($clinic_check_query_run) > 0) {
            mysqli_stmt_close($clinic_check_query_run);
            /* mysqli_close($con); */
            $response = 500;
            $msg= "Clinic already exists!";
        }else{
            // Prepare the statement
            $clinic_query = "INSERT INTO clinic (name, description, photo, icon) VALUES (?, ?, ?, ?)";
            $clinic_query_run = mysqli_prepare($con, $clinic_query);
            // Bind the parameters
            mysqli_stmt_bind_param($clinic_query_run, "ssss", $name, $description, $filename, $filename2);

            if(mysqli_stmt_execute($clinic_query_run))
            {
                move_uploaded_file($_FILES['clinicImg']['tmp_name'],$path.'/'.$filename);
                move_uploaded_file($_FILES['clinicIcon']['tmp_name'],$path.'/'.$filename2);
 
                $response = 200;
                $data["name"] = $name;
                $data["description"] = $description;
                $data["photo"] = $filename;
                $data["icon"] = $filename2;

                $msg="Clinic Added Successfully!";

            }else{
                $response = 500;
                $msg ="Something Went Wrong!";
            }

            mysqli_stmt_close($clinic_check_query_run);
            mysqli_stmt_close($clinic_query_run);
        } 

        mysqli_close($con);
    }

    $data["response"] = $response;
    $data["message"] = $msg;
    echo json_encode($data);
}