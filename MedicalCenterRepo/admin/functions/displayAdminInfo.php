<?php

class Admin
{
    public $name;
    public $email;
}

require_once('../../config/dbcon.php');

$query= "SELECT  CONCAT(Fname, ' ', Lname) AS name, email FROM user WHERE role =0";
$query_run = mysqli_prepare($con, $query);
mysqli_stmt_execute($query_run);
$result = mysqli_stmt_get_result($query_run);

if (mysqli_num_rows($result) > 0) {
    $data = [];
    // output data of each row
    for ($i = 0; $row = $result->fetch_assoc(); $i++) {
        $admin = new Admin();
        $admin->name = $row['name'];
        $admin->email = $row['email'];
        array_push($data, $admin);
    }

    echo json_encode($data);

}else{
    echo json_encode("empty");
}

?>
