
<?php
include_once("../dboperation.php");
$obj=new dboperation();
if (isset($_POST['submit']))
{
    $id=$_POST['distid'];// Get the district id from the form using POST method. This id is passed from the editdistrict.php page.
    //$_POST['distid'] is the name of the hidden input field in the editdistrict.php page.
    $District_name=$_POST['district'];// Get the district name from the form using POST method. This name is passed from the editdistrict.php page.
    //$_POST['district'] is the name of the input field in the editcategory.php page. district is the name of the text box.

    $sqlquery="SELECT * FROM tbl_district where districtname='$District_name'";
    $result=$obj->executequery ($sqlquery);
    $rows=mysqli_num_rows($result);
    if($rows==1)
    {
          echo "<script>alert('Already Exist!!');window.location='district.php'</script>";
    
    }
    else{
            $sql="UPDATE tbl_district set districtname='$District_name' where districtid=$id";
    $result=$obj->executequery($sql);
    if ($result == 1)
    {
     echo "<script>alert('Saved Succesfully');window.location='viewdistrict.php' </script>";
    }
    else
    {
     echo "<script>alert('Registration failed');window.location='viewdistrict.php' </script>";
    }
}
}
?>