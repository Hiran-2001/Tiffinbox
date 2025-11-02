<?php
include("header.php");
include_once('../dboperation.php');
$obj=new dboperation();
if(isset($_GET["did"]))
{
    $cid=$_GET["did"];
    $sql="select * from tbl_fooditem where foodid='$cid'";
    $res=$obj->executequery ($sql);
    $r=mysqli_fetch_array($res);



}
?>
            <div class="container-fluid pt-4 px-40">
                <div class="row g-12">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-10">
                            <h6 class="mb-4"> Fooditem </h6>

                            <form action="fooditemeditaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">foodname</label>
                                    <input type="text" name="foodname" class="form-control" id="foodid"
                                        aria-describedby="emailHelp"  value="<?php echo $r["foodname"];?>">
<br>
 
<br>


                                         <td>
                                                    <img src="../uploads/<?php echo $r['image']; ?> "style="width:150px;height:150px;" />         
                                                </td>

                                        <br>
                                     <label for="exampleInputEmail1" class="form-label">image</label>
                                    <input type="file" name="image" class="form-control" id="foodid"
                                        aria-describedby="emailHelp">
                                        <br>
                                  
                                         <label for="exampleInputEmail1" class="form-label">price</label>
                                    <input type="text" name="price" class="form-control" id="foodid"
                                        aria-describedby="emailHelp"  value="<?php echo $r["price"];?>">
                                </div>
                                    <input type="hidden" name="foodid" value="<?php echo $r["foodid"];?>" class="form-control" id="foodid">

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                
                            </form>
                        </div>
                    </div> 

                    <?php
  include_once('footer.php');
  ?>