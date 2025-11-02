<?php
include("../dboperation.php");
$obj=new dboperation();

  $cid=$_GET["did"];
  $sql="delete from tbl_fooditem where foodid=$cid";
  $res=$obj->executequery($sql);
 
  
  echo "<script>alert('Deleted Successfully!!');window.location='fooditemview.php'</script>";

?>