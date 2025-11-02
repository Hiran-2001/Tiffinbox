<?php
  include_once('header.php');
  include_once('../dboperation.php');
$obj=new dboperation();
    $sql="select * from tbl_category";
    $res = $obj->executequery($sql);


  ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">-SUBSCRIPTION SELECTION-</h6>
                            <form action="subscriptionaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">



                                    

                                     <label for="exampleInputEmail1" class="form-label">ENTER THE SUBSCRIPTION PLAN</label>
                                    <input type="text" name="sname" class="form-control" id="location"
                                        aria-describedby="emailHelp">

                                         <label for="exampleInputEmail1" class="form-label">image</label>
                                    <input type="file" name="image" class="form-control" id="categoryid"
                                        aria-describedby="emailHelp">
                                  

                                         <label for="exampleInputEmail1" class="form-label"> NO.OF DAYS</label>
                                    <input type="text" name="noday" class="form-control" id="location"
                                        aria-describedby="emailHelp">


                                         <label for="exampleInputEmail1" class="form-label">AMOUNT</label>
                                    <input type="text" name="amount" class="form-control" id="location"
                                        aria-describedby="emailHelp">

                                         <label for="exampleInputEmail1" class="form-label">DESCRIPTION</label>
                                    <input type="text" name="des" class="form-control" id="location"
                                        aria-describedby="emailHelp">
                    

                    
                                        <label>select a Subscription plan</label>


                    <select class="form-control" name="categoryid"
                    id="seldistrictid">

                    <option>--------Select category-----------</option>
                  <?php
while($display= mysqli_fetch_array($res))
{ ?>


<option value="<?php echo $display["categoryid"]?>"> <?php echo $display["category_name"]?> </option> <?php
}
?>
</select>   
<br>
                                  

                                        
                                     
                                  
                                </div>

                                
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                
                            </form>
                        </div>
                    </div> 

                    <?php
  include_once('footer.php');
  ?>
  

