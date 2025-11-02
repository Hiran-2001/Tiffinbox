<?php
include_once("../dboperation.php");
$obj = new dboperation(); 

if (isset($_GET['rid']) && isset($_GET['status'])) {
    $requestid = $_GET['rid'];
    $status    = $_GET['status']; // 'approved' or 'rejected'

    $sql = "UPDATE tbl_request SET status = '$status' WHERE requestid = '$requestid'";
    $result = $obj->executequery($sql);

    if ($result) {
        echo "<script>alert('Request $status '); 
              window.location.href='viewrequest.php';</script>";
    } else {
        echo "<script>alert('Something went wrong'); 
              window.location.href='viewrequest.php';</script>";
    }
} else
 {
    echo "<script>alert('Invalid Request!'); 
          window.location.href='viewrequest.php';</script>";
}
?>