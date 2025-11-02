<?php
session_start();
include_once("../dboperation.php");

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new dboperation();
    
    // Get form data
    $customername = $_POST['customername'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $housename = $_POST['housename'];
    $landmark = $_POST['landmark'];
    $pincode = $_POST['pincode'];
    $locationid = $_POST['locationid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate required fields
    if(empty($customername) || empty($email) || empty($contactno) || empty($housename) || 
       empty($landmark) || empty($pincode) || empty($locationid) || empty($username) || empty($password)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit();
    }
    
    // Validate email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.'); window.history.back();</script>";
        exit();
    }
    
    // Validate password confirmation
    if($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }
    
    // Check if username already exists
    $check_username = "SELECT customerid FROM tbl_customer WHERE username = '$username'";
    $username_result = $obj->executequery($check_username);
    if(mysqli_num_rows($username_result) > 0) {
        echo "<script>alert('Username already exists. Please choose another username.'); window.history.back();</script>";
        exit();
    }
    
    // Check if email already exists
    $check_email = "SELECT customerid FROM tbl_customer WHERE email = '$email'";
    $email_result = $obj->executequery($check_email);
    if(mysqli_num_rows($email_result) > 0) {
        echo "<script>alert('Email already registered. Please use another email or login.'); window.history.back();</script>";
        exit();
    }
    
    // Insert new customer
    $insert_query = "INSERT INTO tbl_customer (customername, locationid, contactno, email, username, password, housename, pincode, landmark) 
                     VALUES ('$customername', '$locationid', '$contactno', '$email', '$username', '$password', '$housename', '$pincode', '$landmark')";
    
    $result = $obj->executequery($insert_query);
    
    if($result) {
        echo "<script>alert('Account created successfully! Please login with your credentials.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Failed to create account. Please try again.'); window.history.back();</script>";
    }
    
} else {
    echo "<script>alert('Invalid request.'); window.location='signup.php';</script>";
}
?>