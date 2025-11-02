<?php
include_once("../dboperation.php");
$obj=new dboperation();
if (isset($_POST['submit']))
{
    $id=$_POST['foodid'];
    $foodname=$_POST['foodname'];
    $foodimg=$_FILES["image"]["name"];
    $foodprice=$_POST['price'];
    move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/". $foodimg);

    if($foodimg=='')
    {
    $sql1="UPDATE tbl_fooditem set foodname='$foodname' where foodid=$id";
    $result=$obj->executequery($sql1);
    }
    else{
        $sql="UPDATE tbl_fooditem set foodname='$foodname',price='$foodprice' image='$foodimg' where foodid=$id";
    $result=$obj->executequery($sql);
    }
    if ($result == 1){
     echo "<script>alert('Saved Succesfully');window.location='fooditemview.php' </script>";
    }
    else{
     echo "<script>alert('Registration failed');window.location='fooditemview.php' </script>";
    }
}
?>