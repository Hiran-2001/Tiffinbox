<?php
include_once('header.php');
include_once('../dboperation.php');
$obj = new dboperation();

// Fetch districts
$sql = "SELECT * FROM tbl_district";
$res = $obj->executequery($sql);
?>

<script src="../jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#districtid").change(function() {
            var district_id = $(this).val();
            $.ajax({
                url: "../Guest/get_loc_drpdwn.php",
                method: "POST",
                data: { districtid: district_id },
                success: function(response) {
                    $("#locationid").html(response);
                },
                error: function() {
                    $("#locationid").html("<option>Error loading locations</option>");
                }
            });
        });
    });
</script>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Register Testimonial</h6>

                <form action="deliverypersonaction.php" method="POST">
                    
                    <label>Name</label>
                    <input type="text" name="name" class="form-control mb-3" required>

                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control mb-3" required>

                    <label>Email</label>
                    <input type="email" name="email" class="form-control mb-3" required>

                    <label>District</label>
                    <select class="form-control mb-3" name="districtid" id="districtid" required>
                        <option value="">-- Select District --</option>
                        <?php while ($display = mysqli_fetch_array($res)) { ?>
                            <option value="<?php echo $display['districtid']; ?>">
                                <?php echo $display['districtname']; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label>Location</label>
                    <select class="form-control mb-3" name="locationid" id="locationid" required>
                        <option value="">-- Select Location --</option>
                    </select>

                    <label>Landmark</label>
                    <input type="text" name="landmark" class="form-control mb-3" required>

                    <label>Username</label>
                    <input type="text" name="username" class="form-control mb-3" required>

                    <label>Password</label>
                    <input type="password" name="password" class="form-control mb-3" required>

                    <label>House No</label>
                    <input type="text" name="houseno" class="form-control mb-3" required>

                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control mb-3" required>

                    <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once('footer.php');
?>