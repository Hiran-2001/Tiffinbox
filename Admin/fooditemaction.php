 <?php
    include("../dboperation.php");
    $obj=new dboperation();

    if(isset($_POST['submit']))
    {

    $f=$_POST['food'];
    $r=$_POST['price'];
    $c=$_POST['categoryid'];
    $i=$_FILES['image']['name'];
    $m=$_POST['mealtypeid'];

    move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $i);

    $sqlquery="SELECT * FROM tbl_fooditem where foodname='$c'";
    $result=$obj->executequery ($sqlquery);
    $rows=mysqli_num_rows($result);
    if($rows==1)
    {
          echo "<script>alert('Already Exist!!');window.location='fooditem.php'</script>";
    
    }
    else
    {
       $sqlquery1="INSERT INTO tbl_fooditem (foodname,image,price,categoryid,mealtypeid) VALUES('$f','$i','$r','$c','$m')";
        $result1=$obj->executequery  ($sqlquery1);
        if($result1==1)
        {
          echo "<script>alert('Registration Succesfully!!');window.location='fooditem.php'</script>";
    
        }
        else
        {
        echo "<script>alert('Registration Failed!!');window.location='fooditem.php'</script>";
}
}
}
?>