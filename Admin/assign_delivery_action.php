<?php
include("../dboperation.php");
$obj = new dboperation();

if (isset($_POST['submit'])) {
    $requestid = $_POST['requestid'];
    $deliverypersonid = $_POST['deliverypersonid'];

    $sql = "UPDATE tbl_request 
            SET deliverypersonid = '$deliverypersonid', status='Assigned'
            WHERE requestid = '$requestid'";

    if ($obj->executequery($sql)) {
        echo "<script>alert('Delivery person assigned successfully'); window.location.href='requestlist.php';</script>";
    } else {
        echo "<script>alert('Error assigning delivery person'); window.history.back();</script>";
    }
}
?>