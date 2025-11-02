<?php
include("../dboperation.php");
$obj=new dboperation();

  $did=$_GET["did"];
  $sql="delete from tbl_district where districtid=$did";
  $res=$obj->executequery($sql);
 
  
  echo "<script>alert('Deleted Successfully!!');window.location='districtview.php'</script>";

?>