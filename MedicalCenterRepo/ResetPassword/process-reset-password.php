<?php 
session_start();

if(isset($_POST["token"])){
    $token = $_POST["token"];

    $token_hash = hash("sha256", $token);

    include("../config/dbcon.php");

    function redirect($url, $message){
        $_SESSION['message']= $message;
        header('Location: ' .$url);
        exit();
    }

    // Function to validate password
    function validatePass($pass) {
        $passRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
        return preg_match($passRegex, $pass);
    }

    $sql = "SELECT * FROM user WHERE reset_token_hash = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token_hash);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user === null) {
        die("token not found");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("token has expired");
    }

    if ($_POST["password"] !== $_POST["cpassword"]) {
        /* die("Passwords must match"); */
        redirect('reset-password.php?token='.$token,"Passwords must match");
    }

    if(validatePass($_POST["password"])){
        $password = $_POST["password"];

    $sql2 = "UPDATE user 
            SET password = ?, 
                reset_token_hash = NULL, 
                reset_token_expires_at = NULL 
            WHERE userId = ?";

    $stmt = mysqli_prepare($con, $sql2);
    if ($stmt === false) {
        die("Error in preparing statement: " . mysqli_error($con));
    }

    $id = $user["userId"]; // Assuming $user["id"] holds the user's ID
    $hashedNewPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "si", $hashedNewPassword, $id);

    mysqli_stmt_execute($stmt);

    /* echo "Password updated. You can now login."; */
    redirect('success-reset-page.php',"Password updated. You can now login.");

    } else{
        /* die("password not valid."); */
        redirect('reset-password.php?token='.$token,"Invalid Password.");
    }

}else{
    die("token not found");
}

?>