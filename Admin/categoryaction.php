<?php
    include("../dboperation.php");
    $obj=new dboperation();

    if(isset($_POST['submit']))
    {

    $c=$_POST['category'];
    $i=$_FILES['image']['name'];

    move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $i);

    $sqlquery="SELECT * FROM tbl_category where category_name='$c'";
    $result=$obj->executequery($sqlquery);
    $rows=mysqli_num_rows($result);
    if($rows==1)
    {
          echo "<script>alert('Already Exist!!');window.location='category.php'</script>";
    
    }
    else
    {
       $sqlquery1="INSERT INTO tbl_category (category_name,image) VALUES('$c','$i')";
        $result1=$obj->executequery ($sqlquery1);
        if($result1==1)
        {
          echo "<script>alert('Registration Succesfully!!');window.location='districtreg.php'</script>";
    
        }
        else
        {
        echo "<script>alert('Registration Failed!!');window.location='districtreg.php'</script>";
}
}
}
?>