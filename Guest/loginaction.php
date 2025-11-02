<?php
session_start();
include_once("../dboperation.php");
$obj = new dboperation();
$username = $_POST["username"];
$password = $_POST["password"];

//Checking username and password on admin table
$sqlquery = "select * from tbl_adminlogin where username='$username' and password='$password'";
$result= $obj->executequery($sqlquery);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $_SESSION["user_name"] = $username;
    $_SESSION["login_id"] = $row["Login_id"];
    header("location:..\Admin\adminindex.php");
    die();
} 


//Checking username and password on user table
$sqlquery1 = "select * from tbl_customer where username='$username' and password='$password'";
$result1= $obj->executequery($sqlquery1);

if (mysqli_num_rows($result1) == 1) {
    $row1  = mysqli_fetch_array($result1);
    $_SESSION["username"] = $username;
    $_SESSION["customerid"] = $row1["customerid"];
    header("location:..\customer\index.php");
    // die();
}

$sqlquery2 = "select * from tbl_deliveryperson where username='$username' and password='$password'";
$result2= $obj->executequery($sqlquery2);

if (mysqli_num_rows($result2) == 1) {
    $row2  = mysqli_fetch_array($result2);
    $_SESSION["username"] = $username;
    $_SESSION["customerid"] = $row2["customerid"];
    header("location:..\Deliveryperson\index.php");
    // die();
}

//if username and password didn't match any of the table, this will work
echo "<script>alert('Invalid Username/Password!!'); window.location='login.php'</script>";


?>