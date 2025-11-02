<?php
include_once("header.php");
include_once("../dboperation.php");
$obj = new dboperation();

// Fetch all delivery persons
$sql = "SELECT dp.deliverypersonid, dp.name, dp.phone, dp.email, d.districtname, l.locationname, dp.landmark, dp.username, dp.houseno, dp.pincode
        FROM tbl_deliveryperson dp
        LEFT JOIN tbl_district d ON dp.districtid = d.districtid
        LEFT JOIN tbl_location l ON dp.locationid = l.locationid
        ORDER BY dp.deliverypersonid DESC";
$res = $obj->executequery($sql);
?>

<br><br><br>

<div class="container">
    <h2 class="text-center mb-4">Delivery Person List</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>District</th>
                <th>Location</th>
                <th>Landmark</th>
                <th>Username</th>
                <th>House No</th>
                <th>Pincode</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                            <td>{$row['deliverypersonid']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['districtname']}</td>
                            <td>{$row['locationname']}</td>
                            <td>{$row['landmark']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['houseno']}</td>
                            <td>{$row['pincode']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='text-center'>No Delivery Persons Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include("footer.php"); ?>