<?php
include("../dboperation.php");
$obj=new dboperation();

  $cid=$_GET["locationid"];
  $sql="delete from tbl_location where locationid=$cid";
  $res=$obj->executequery($sql);
 
  
  echo "<script>alert('Deleted Successfully!!');window.location='locationview.php'</script>";

?>