<?php
  include_once('header.php');

  include_once('../dboperation.php');
$obj=new dboperation();
$s=$_GET["subscriptionid"];

$sq="select * from tbl_subscription where subscriptionid=$s";
$r = $obj->executequery($sq);

$sql="select * from tbl_fooditem INNER JOIN tbl_subscription on tbl_fooditem.categoryid = tbl_subscription.categoryid 
where tbl_subscription.subscriptionid='$s' and tbl_fooditem.mealtypeid='1'";
$res1 = $obj->executequery($sql);




$sql="select * from tbl_fooditem INNER JOIN tbl_subscription on tbl_fooditem.categoryid = tbl_subscription.categoryid 
where tbl_subscription.subscriptionid='$s' and tbl_fooditem.mealtypeid='2'";
$res2 = $obj->executequery($sql);




$sql="select * from tbl_fooditem INNER JOIN tbl_subscription on tbl_fooditem.categoryid = tbl_subscription.categoryid 
where tbl_subscription.subscriptionid='$s' and tbl_fooditem.mealtypeid='3'";
$res3 = $obj->executequery($sql);




  ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">MENU SELECTION</h6>
                            <form action="food_add_sub_action.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">

            <label for="exampleInputEmail1" class="form-label"> NO.OF DAYS</label>
                                    <input type="text" name="n" class="form-control" id="location"
                                        aria-describedby="emailHelp">




                                </div>

                                     <label>Select a Breakfast</label>

                    <select class="form-control" name="bf"
                    id="">

                    <option>--------Select Breakfast-----------</option>
                  <?php
while($display= mysqli_fetch_array($res1))
{ ?>


<option value="<?php echo $display["foodid"]?>"> <?php echo $display["foodname"]?> </option> <?php
}
?>
</select>   



                            <label>Select a Lunch</label>

                            <select class="form-control" name="l" id="">

                            <option>--------Select lunch-----------</option>
                            
                            <?php
                            while($display= mysqli_fetch_array($res2))
                            { ?>


                            <option value="<?php echo $display["foodid"]?>"> <?php echo $display["foodname"]?> </option> <?php
                            }
                            ?>
                            </select>   


                            <label>Select a Dinner</label>

                            <select class="form-control" name="d" id="">

                            <option>--------Select Dinner-----------</option>
                            
                            <?php
                            while($display= mysqli_fetch_array($res3))
                            { ?>


                            <option value="<?php echo $display["foodid"]?>"> <?php echo $display["foodname"]?> </option> <?php
                            }
                            ?>
                            </select>   




                            <?php
                            while($display= mysqli_fetch_array($r))
                            { ?>

                                 <input type="hidden" name="subid" value="<?php echo $display["subscriptionid"]?>" class="form-control" id="location">

                             <?php
                            }
                            ?>

<br>

                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>


                                </div>

                                
                                
                            </form>
                        </div>
                    </div> </div>

                    <?php
  include_once('footer.php');
  ?>