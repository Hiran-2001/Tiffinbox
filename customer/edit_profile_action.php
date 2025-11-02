<?php
session_start();
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["customerid"])) {
    echo "<script>alert('Please login to update your profile.'); window.location='login.php'</script>";
    exit();
}

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new dboperation();
    $customerid = $_SESSION["customerid"];
    
    // Get form data
    $customername = $_POST['customername'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $housename = $_POST['housename'];
    $landmark = $_POST['landmark'];
    $pincode = $_POST['pincode'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate required fields
    if(empty($customername) || empty($username) || empty($email) || empty($contactno) || 
       empty($housename) || empty($landmark) || empty($pincode)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit();
    }
    
    // Validate email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.'); window.history.back();</script>";
        exit();
    }
    
    // Check if username is already taken (by someone else)
    $check_username = "SELECT customerid FROM tbl_customer WHERE username = '$username' AND customerid != '$customerid'";
    $username_result = $obj->executequery($check_username);
    if(mysqli_num_rows($username_result) > 0) {
        echo "<script>alert('Username is already taken. Please choose another one.'); window.history.back();</script>";
        exit();
    }
    
    // Check if email is already taken (by someone else)
    $check_email = "SELECT customerid FROM tbl_customer WHERE email = '$email' AND customerid != '$customerid'";
    $email_result = $obj->executequery($check_email);
    if(mysqli_num_rows($email_result) > 0) {
        echo "<script>alert('Email is already registered. Please use another email.'); window.history.back();</script>";
        exit();
    }
    
    // Handle password update
    $password_update = "";
    if(!empty($password)) {
        if($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
            exit();
        }
        if(strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters long.'); window.history.back();</script>";
            exit();
        }
        $password_update = ", password = '$password'";
    }
    
    // Update customer information
    $update_query = "UPDATE tbl_customer SET 
                     customername = '$customername',
                     username = '$username',
                     email = '$email',
                     contactno = '$contactno',
                     housename = '$housename',
                     landmark = '$landmark',
                     pincode = '$pincode'
                     $password_update
                     WHERE customerid = '$customerid'";
    
    $result = $obj->executequery($update_query);
    
    if($result) {
        // Update session username if it was changed
        $_SESSION["username"] = $username;
        echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile. Please try again.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='profile.php';</script>";
}
?>