<?php
require_once('../../config/dbcon.php');

function redirect($url, $message){
    $_SESSION['message']= $message;
    header('Location: ' .$url);
    exit();
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate name
function validateName($name) {
    $nameRegex = '/^[a-zA-Z]+$/';
    return preg_match($nameRegex, $name);
}

// Function to validate desc
function validateDesc($desc) {
    $descRegex = '/^[a-zA-Z\s]+$/';
    return preg_match($descRegex, $desc);
}

// Function to validate email
function validateEmail($email) {
    $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    return preg_match($emailRegex, $email);
}

// Function to validate password
function validatePass($pass) {
    $passRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
    return preg_match($passRegex, $pass);
}

// Function to validate phone
function validatePhone($phone) {
    $lebanesePhoneRegex = '/^\d{8}$/';
    /* $lebanesePhoneRegex = '/^(?:\+961|0\d{1,2}) \d{3} \d{3}$/'; */
    return preg_match($lebanesePhoneRegex, $phone);
}

?>