<?php
include_once("../dboperation.php");
$obj = new dboperation();

if (isset($_POST['submit'])) {
    $name       = $_POST['name'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $districtid = $_POST['districtid'];
    $locationid = $_POST['locationid'];
    $landmark   = $_POST['landmark'];
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $houseno    = $_POST['houseno'];
    $pincode    = $_POST['pincode'];

   

    // Insert query for delivery person
    $sql = "INSERT INTO tbl_deliveryperson (name, phone, email, districtid, locationid, landmark, username, password, houseno, pincode) 
            VALUES ('$name', '$phone', '$email', '$districtid', '$locationid', '$landmark', '$username', '$password', '$houseno', '$pincode')";

    $res = $obj->executequery($sql);

    if ($res) {
        echo "<script>alert('Delivery Person Registered Successfully!'); window.location.href='deliverypersonlist.php';</script>";
    } else {
        echo "<script>alert('Error while registering delivery person!'); window.history.back();</script>";
    }
}
?>