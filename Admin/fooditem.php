<?php
  include_once('header.php');

  include_once('../dboperation.php');
$obj=new dboperation();
    $sql="select * from tbl_category";
    $res = $obj->executequery ($sql);


$sql="select * from tbl_mealtype";
    $r = $obj->executequery($sql);
    



  ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">FoodItem Registration</h6>
                            <form action="fooditemaction.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">

                                </div>

                                     <label>Select a category</label>

                    <select class="form-control" name="categoryid"
                    id="">

                    <option>--------Select Category-----------</option>
                  <?php
while($display= mysqli_fetch_array($res))
{ ?>


<option value="<?php echo $display["categoryid"]?>"> <?php echo $display["category_name"]?> </option> <?php
}
?>
</select>   



                            <label>Select a mealtype</label>

                            <select class="form-control" name="mealtypeid" id="">

                            <option>--------Select mealtype-----------</option>
                            
                            <?php
                            while($display= mysqli_fetch_array($r))
                            { ?>


                            <option value="<?php echo $display["mealtypeid"]?>"> <?php echo $display["typename"]?> </option> <?php
                            }
                            ?>
                            </select>   


                                    <label for="exampleInputEmail1" class="form-label">Food Item</label>
                                    <input type="text" name="food" class="form-control" id="foodid"
                                        aria-describedby="emailHelp">
                                        
                                     <label for="exampleInputEmail1" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" id="foodid"
                                        aria-describedby="emailHelp">


                                    <label for="exampleInputEmail1" class="form-label">Price</label>
                                    <input type="text" name="price" class="form-control" id="foodid"
                                        aria-describedby="emailHelp">
                                        <br>

                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>


                                </div>

                                
                                
                            </form>
                        </div>
                    </div> </div>

                    <?php
  include_once('footer.php');
  ?>