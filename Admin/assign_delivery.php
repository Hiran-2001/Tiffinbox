<?php
include('header.php');
include("../dboperation.php");
$obj = new dboperation();

if (!isset($_GET['rid'])) {
    echo "<div class='alert alert-danger'>Invalid Request ID.</div>";
    include('footer.php');
    exit;
}

$requestid = $_GET['rid'];

// Fetch delivery address of this request
$sql = "SELECT da.*, l.locationname, d.districtname 
        FROM tbl_deliveryaddress da
        INNER JOIN tbl_location l ON da.locationid = l.locationid
        INNER JOIN tbl_district d ON l.districtid = d.districtid
        WHERE da.requestid = '$requestid'";
$addrRes = $obj->executequery($sql);
$deliveryAddr = mysqli_fetch_array($addrRes);

if (!$deliveryAddr) {
    echo "<div class='alert alert-warning'>No delivery address found for this request.</div>";
    include('footer.php');
    exit;
}

// Fetch delivery persons from same location
$sqlDP = "SELECT * FROM tbl_deliveryperson WHERE locationid = '" . $deliveryAddr['locationid'] . "'";
$dpRes = $obj->executequery($sqlDP);

?>
<br><br><br>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow p-4">
                <h4 class="mb-4">Assign Delivery Person</h4>

                <!-- Delivery Address Details -->
                <h5>Delivery Address</h5>
                <table class="table table-bordered">
                    <tr><th>Name</th><td><?php echo $deliveryAddr['name']; ?></td></tr>
                    <tr><th>Contact</th><td><?php echo $deliveryAddr['contact']; ?></td></tr>
                    <tr><th>House No</th><td><?php echo $deliveryAddr['houseno']; ?></td></tr>
                    <tr><th>Landmark</th><td><?php echo $deliveryAddr['landmark']; ?></td></tr>
                    <tr><th>Pincode</th><td><?php echo $deliveryAddr['pincode']; ?></td></tr>
                    <tr><th>Location</th><td><?php echo $deliveryAddr['locationname']; ?></td></tr>
                    <tr><th>District</th><td><?php echo $deliveryAddr['districtname']; ?></td></tr>
                </table>

                <!-- Assign Delivery Person Form -->
                <form action="assign_delivery_action.php" method="post">
                    <input type="hidden" name="requestid" value="<?php echo $requestid; ?>">

                    <div class="mb-3">
                        <label for="deliverypersonid" class="form-label">Select Delivery Person</label>
                        <select class="form-control" name="deliverypersonid" id="deliverypersonid" required>
                            <option value="">-- Select Delivery Person --</option>
                            <?php while ($dp = mysqli_fetch_array($dpRes)) { ?>
                                <option value="<?php echo $dp['deliverypersonid']; ?>">
                                    <?php echo $dp['name'] . " (" . $dp['phone'] . ")"; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <button type="submit" name="submit" class="btn btn-success">Assign</button>
                    <a href="requestlist.php" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>