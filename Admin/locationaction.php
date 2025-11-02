<?php
    include_once("../dboperation.php");
    $obj=new dboperation();
    if(isset($_POST['submit']))
    {
    $locationname=$_POST['locationname'];
    $districtid=$_POST['districtid'];
    $sqlquery="SELECT * FROM tbl_location where locationname='$locationname'";
    $result=$obj->executequery ($sqlquery);
    $rows=mysqli_num_rows($result);
    if($rows==1)
    {
          echo "<script>alert('Already Exist!!');window.location='location.php'</script>";
    
    }
    else
    {
       $sqlquery1="INSERT INTO tbl_location (locationname,districtid) VALUES('$locationname','$districtid')";
        $result1=$obj->executequery($sqlquery1);
        if($result1==1)
        {
          echo "<script>alert('Registration Succesfully!!');window.location='location.php'</script>";
    
        }
        else
        {
        echo "<script>alert('Registration Failed!!');window.location='location.php'</script>";
}
}
}
?>







