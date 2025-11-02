<?php
include("../dboperation.php");
$obj=new dboperation();

  $cid=$_GET["did"];
  $sql="delete from tbl_category where category_id=$cid";
  $res=$obj->executequery($sql);
 
  
  echo "<script>alert('Deleted Successfully!!');window.location='categoryview.php'</script>";

?>