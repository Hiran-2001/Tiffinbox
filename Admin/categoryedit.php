<?php
include("header.php");
include_once('../dboperation.php');
$obj=new dboperation();
if(isset($_GET["did"]))
{
    $cid=$_GET["did"];
    $sql="select * from tbl_category where category_id='$cid'";
    $res=$obj->executequery($sql);
    $r=mysqli_fetch_array($res);

}
?>
            <div class="container-fluid pt-4 px-40">
                <div class="row g-12">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-10">
                            <h6 class="mb-4"> CATEGORY </h6>

                            <form action="categoryeditaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">category</label>
                                    <input type="text" name="category" class="form-control" id="categoryid"
                                        aria-describedby="emailHelp"  value="<?php echo $r["category_name"];?>">
<br>


                                         <td>
                                                    <img src="../uploads/<?php echo $r['image']; ?> "style="width:150px;height:150px;" />         
                                                </td>

                                        <br>
                                     <label for="exampleInputEmail1" class="form-label">image</label>
                                    <input type="file" name="image" class="form-control" id="categoryid"
                                        aria-describedby="emailHelp">
                                  
                                </div>
                                    <input type="hidden" name="categoryid" value="<?php echo $r["category_id"];?>" class="form-control" id="categoryid">

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                
                            </form>
                        </div>
                    </div> 

                    <?php
  include_once('footer.php');
  ?>