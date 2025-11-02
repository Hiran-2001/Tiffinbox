<?php
include_once("../dboperation.php");
$obj=new dboperation();
if (isset($_POST['submit']))
{
    $id=$_POST['categoryid'];
    $Category_name=$_POST['category'];
    $Categoryimg=$_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/". $Categoryimg);

    if($Categoryimg=='')
    {
    $sql1="UPDATE tbl_category set category_name='$Category_name' where category_id=$id";
    $result=$obj->executequery($sql1);
    }
    else{
        $sql="UPDATE tbl_category set category_name='$Category_name', image='$Categoryimg' where category_id=$id";
    $result=$obj->executequery($sql);
    }
    if ($result == 1){
     echo "<script>alert('Saved Succesfully');window.location='categoryview.php' </script>";
    }
    else{
     echo "<script>alert('Registration failed');window.location='categoryview.php' </script>";
    }
}
?>