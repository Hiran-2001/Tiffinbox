<?php
  include_once('header.php');
  include_once('../dboperation.php');
$obj=new dboperation();
    $sql="select * from tbl_district";
    $res = $obj->executequery($sql);


  ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">location Registration</h6>
                            <form action="locationaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">



                                     <label>select a district</label>

                    <select class="form-control" name="districtid"
                    id="seldistrictid" onchange="this.form.submit()">

                    <option>--------Select District-----------</option>
                  <?php
while($display= mysqli_fetch_array($res))
{ ?>


<option value="<?php echo $display["districtid"]?>"> <?php echo $display["districtname"]?> </option> <?php
}
?>
</select>   
<br>
                                    <label for="exampleInputEmail1" class="form-label">Select your Place</label>
                                    <input type="text" name="locationname" class="form-control" id="location"
                                        aria-describedby="emailHelp">

                                        
                                     
                                  
                                </div>

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                
                            </form>
                        </div>
                    </div> 

                    <?php
  include_once('footer.php');
  ?>
  

