<?php

require("../config/dbcon.php");

function redirect($url, $message){
    $_SESSION['message']= $message;
    header('Location: ' .$url);
    exit();
}

function getRowCount($table){
    global $con;
    $query= "SELECT * FROM $table";
    $query_run = mysqli_prepare($con, $query);
    mysqli_stmt_execute($query_run);
    $result = mysqli_stmt_get_result($query_run);
    return mysqli_num_rows($result);
}

?>