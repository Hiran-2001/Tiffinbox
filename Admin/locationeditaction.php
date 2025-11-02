<?php
include_once("../dboperation.php");
$obj=new dboperation();
if (isset($_POST['submit']))
{
    $id=$_POST['locationid'];
    $locationname=$_POST['locationname'];
   
    $sql1="UPDATE tbl_location set locationname='$locationname' where locationid=$id";
    $result=$obj->executequery($sql1);
    
    if ($result == 1){
     echo "<script>alert('Saved Succesfully');window.location='locationview.php' </script>";
    }
    else{
     echo "<script>alert('Registration failed');window.location='locationview.php' </script>";
    }
}
?>

