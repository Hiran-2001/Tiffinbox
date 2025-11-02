<?php
include("../dboperation.php");
$obj=new dboperation();

  $sid=$_GET["sid"];
  $d=$_GET["display"];
  $d1=$_GET["d1"];
  $d2=$_GET["d2"];
  

  $sql1="delete from tbl_mealplandetails where detailsid=$d";
  $res1=$obj->executequery($sql1);
 

 $sql2="delete from tbl_mealplandetails where detailsid=$d1";
  $res2=$obj->executequery($sql2);

   $sql3="delete from tbl_mealplandetails where detailsid=$d2";
  $res3=$obj->executequery($sql3);


 
  echo "<script>alert('Deleted Successfully!!');window.location='menudetails.php?subscriptionid=$sid'</script>";

?>