<?php
    include_once("../dboperation.php");
    $obj=new dboperation();
    if(isset($_POST['submit']))
    {
    $subname=$_POST['sname'];
    $d=$_POST['noday'];
    $a=$_POST['amount'];
    $des=$_POST['des'];
    $c=$_POST['categoryid'];
    $i=$_FILES['image']['name'];

    move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $i);

    $sqlquery="SELECT * FROM tbl_subscription where subname='$subname'";
    $result=$obj-> executequery ($sqlquery);
    $rows=mysqli_num_rows($result);
    if($rows==1)
    {
          echo "<script>alert('Already Exist!!');window.location='subscription.php'</script>";
    
    }
    else
    {
       $sqlquery1="INSERT INTO tbl_subscription (subname,day,amount,description,categoryid,image)
                         VALUES('$subname','$d','$a','$des','$c','$i')";
        $result1=$obj->executequery($sqlquery1);
        if($result1==1)
        {
          echo "<script>alert('Registration Succesfully!!');window.location='subscription.php'</script>";
    
        }
        else
        {
        echo "<script>alert('Registration Failed!!');window.location='subscription.php'</script>";
}
}
}
?>







