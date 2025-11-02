<?php
session_start();
include_once("../dboperation.php");

if(isset($_GET['id']) && isset($_SESSION["customerid"])) {
    $requestid = $_GET['id'];
    $customerid = $_SESSION["customerid"];
    
    $obj = new dboperation();
    
    // Delete the request
    $delete_query = "DELETE FROM tbl_request WHERE requestid = '$requestid' AND customerid = '$customerid'";
    $result = $obj->executequery($delete_query);
    
    if($result) {
        echo "<script>alert('Order cancelled successfully!'); window.location='orders.php';</script>";
    } else {
        echo "<script>alert('Failed to cancel order!'); window.location='orders.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location='orders.php';</script>";
}
?>
