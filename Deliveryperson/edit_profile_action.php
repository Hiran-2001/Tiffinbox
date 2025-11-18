<?php
session_start();
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["deliverypersonid"])) {
    echo "<script>alert('Please login to update your profile.'); window.location='login.php'</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $obj = new dboperation();
    $deliverypersonid = $_SESSION["deliverypersonid"];

    // Build the UPDATE query dynamically
    $updates = [];

    // Name
    if(!empty($_POST['name'])) {
        $name = $_POST['name'];
        $updates[] = "name = '$name'";
    }

    // Username
    if(!empty($_POST['username'])) {
        $username = $_POST['username'];

        // Check if new username is taken
        $check_username = "SELECT deliverypersonid FROM tbl_deliveryperson 
                           WHERE username = '$username' AND deliverypersonid != '$deliverypersonid'";
        $res = $obj->executequery($check_username);

        if(mysqli_num_rows($res) > 0) {
            echo "<script>alert('Username already taken.'); window.history.back();</script>";
            exit();
        }

        $updates[] = "username = '$username'";
        $_SESSION["username"] = $username; // update session
    }

    // Email
    if(!empty($_POST['email'])) {
        $email = $_POST['email'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Enter a valid email'); window.history.back();</script>";
            exit();
        }

        $check_email = "SELECT deliverypersonid FROM tbl_deliveryperson 
                        WHERE email = '$email' AND deliverypersonid != '$deliverypersonid'";
        $res = $obj->executequery($check_email);

        if(mysqli_num_rows($res) > 0) {
            echo "<script>alert('Email already used.'); window.history.back();</script>";
            exit();
        }

        $updates[] = "email = '$email'";
    }

    // Phone
    if(!empty($_POST['phone'])) {
        $updates[] = "phone = '{$_POST['phone']}'";
    }

    // House no
    if(!empty($_POST['houseno'])) {
        $updates[] = "houseno = '{$_POST['houseno']}'";
    }

    // Landmark
    if(!empty($_POST['landmark'])) {
        $updates[] = "landmark = '{$_POST['landmark']}'";
    }

    // Pincode
    if(!empty($_POST['pincode'])) {
        $updates[] = "pincode = '{$_POST['pincode']}'";
    }

    // Password update
    if(!empty($_POST['password'])) {
        if($_POST['password'] !== $_POST['confirm_password']) {
            echo "<script>alert('Passwords do not match'); window.history.back();</script>";
            exit();
        }

        if(strlen($_POST['password']) < 6) {
            echo "<script>alert('Password must be at least 6 characters'); window.history.back();</script>";
            exit();
        }

        $updates[] = "password = '{$_POST['password']}'";
    }

    // If no fields updated
    if(count($updates) == 0) {
        echo "<script>alert('No changes to update.'); window.location='profile.php';</script>";
        exit();
    }

    // Convert update list to SQL
    $update_sql = "UPDATE tbl_deliveryperson SET " . implode(", ", $updates) . 
                  " WHERE deliverypersonid = '$deliverypersonid'";

    $result = $obj->executequery($update_sql);

    if($result) {
        echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Update failed. Try again.'); window.history.back();</script>";
    }
}
?>
