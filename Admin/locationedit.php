<?php
include("header.php");
include_once('../dboperation.php');
$obj=new dboperation();
if(isset($_GET["locationid"]))
{
    
    $sql="select * from tbl_location l inner join tbl_district d on l.districtid=d.districtid";
    $res=$obj->executequery($sql);
    $r=mysqli_fetch_array($res);

}
?>
            <div class="container-fluid pt-4 px-40">
                <div class="row g-12">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-10">
                            <h6 class="mb-4"> LOCATION </h6>

                            <form action="locationeditaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">District</label>
                                    <input type="text" name="category" class="form-control" id="categoryid"
                                        aria-describedby="emailHelp"  value="<?php echo $r["districtname"];?>" readonly>
<br>

                                        <br>
                                     <label for="exampleInputEmail1" class="form-label">LocationName</label>
                                    <input type="text" name="locationname" class="form-control" id="locationid"
                                      value="<?php echo $r["locationname"];?>">
                                  
                                </div>
                                    <input type="hidden" name="locationid" value="<?php echo $r["locationid"];?>" class="form-control" id="locationid">

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                
                            </form>
                        </div>
                    </div> 

                    <?php
  include_once('footer.php');
  ?>