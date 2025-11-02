<?php
include("../dboperation.php");
$obj=new dboperation();

  $cid=$_GET["did"];
  $sql="delete from tbl_subscription where subscriptionid=$cid";
  $res=$obj->executequery($sql);
 
  
  echo "<script>alert('Deleted Successfully!!');window.location='subscriptionview.php'</script>";

?>