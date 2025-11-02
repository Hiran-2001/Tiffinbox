<?php
include("header.php");
include("../dboperation.php");
$obj = new dboperation();


$sid = $_GET["subscriptionid"];

/* ────── three separate result‑sets ────── */
$s = "SELECT * FROM tbl_subscription
       INNER JOIN tbl_mealplandetails  ON tbl_subscription.subscriptionid = tbl_mealplandetails.subscriptionid
       INNER JOIN tbl_fooditem     ON tbl_mealplandetails.foodid        = tbl_fooditem.foodid
       WHERE tbl_subscription.subscriptionid = '$sid' AND tbl_fooditem.mealtypeid = '1'";
$res = $obj->executequery($s);

$s1 = "SELECT * FROM tbl_subscription
       INNER JOIN tbl_mealplandetails  ON tbl_subscription.subscriptionid = tbl_mealplandetails.subscriptionid
       INNER JOIN tbl_fooditem     ON tbl_mealplandetails.foodid        = tbl_fooditem.foodid
       WHERE tbl_subscription.subscriptionid = '$sid' AND tbl_fooditem.mealtypeid = '2'";
$r1 = $obj->executequery($s1);

$s2 = "SELECT * FROM tbl_subscription
       INNER JOIN tbl_mealplandetails  ON tbl_subscription.subscriptionid = tbl_mealplandetails.subscriptionid
       INNER JOIN tbl_fooditem     ON tbl_mealplandetails.foodid        = tbl_fooditem.foodid
       WHERE tbl_subscription.subscriptionid = '$sid' AND tbl_fooditem.mealtypeid = '3'";
$r2 = $obj->executequery($s2);
?>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Categories</h3>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                   
                    <th>Day num</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  /* loop through breakfast rows; pull one matching lunch + dinner row each time */
                  while ($display = mysqli_fetch_array($res)) {

                    /* fetch one row from the other two result‑sets */
                    $d1 = mysqli_fetch_array($r1);
                    $d2 = mysqli_fetch_array($r2);
                    ?>
                    <tr>
                      <td class="py-1"><?php echo $display["daynum"]; ?></td>

                      <td>
                        <?php echo $display["foodname"]; ?><br><br>
                        <img src="../uploads/<?php echo $display['image']; ?>" alt="image"
                          style="width:120px;height:80px;object-fit:cover;border-radius:5px;" />
                      </td>

                      <td>
                        <?php echo $d1["foodname"]; ?><br><br>
                        <img src="../uploads/<?php echo $d1['image']; ?>" alt="image"
                          style="width:120px;height:80px;object-fit:cover;border-radius:5px;" />
                      </td>

                      <td>
                        <?php echo $d2["foodname"]; ?><br><br>
                        <img src="../uploads/<?php echo $d2['image']; ?>" alt="image"
                          style="width:120px;height:80px;object-fit:cover;border-radius:5px;" />
                      </td>

                      <td><!-- Image column duplicated? keep/remove as needed --></td>

                      
                      <input type="hidden" value="<?php echo $d2["subscriptionid"];?>" name="sid">
                      <input type="hidden" value="<?php echo $display["detailsid"];?>" name="display">
                      <input type="hidden" value="<?php echo $d1["detailsid"];?>" name="d1">
                      <input type="hidden" value="<?php echo $d2["detailsid"];?>" name="d2">

                      
 <td><a href="menudetaildelete.php?display=<?php echo $display['detailsid']; ?>&d1=<?php echo $d1['detailsid']; ?>&d2=<?php echo $d2['detailsid']; ?>&sid=<?php echo $d2['subscriptionid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>


                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>