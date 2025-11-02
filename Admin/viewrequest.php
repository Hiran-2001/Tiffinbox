<?php
include('header.php');
include("../dboperation.php");
$obj = new dboperation();

// Join request + customer + subscription
$sql = "SELECT r.requestid, r.date, r.startdate, r.status, 
               c.customername, c.contactno, c.email, 
               s.subname, s.amount
        FROM tbl_request r
        INNER JOIN tbl_customer c ON r.customerid = c.customerid
        INNER JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid
        ORDER BY r.requestid DESC";
$res = $obj->executequery($sql);
?>
<br><br><br>
<br><br><br>
<div class="col-sm-12">
  <div class="bg-light rounded h-100 p-4">
    <h6 class="mb-4">Subscription Requests</h6>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Request ID</th>
          <th scope="col">Customer Name</th>
          <th scope="col">Contact</th>
          <th scope="col">Email</th>
          <th scope="col">Subscription</th>
          <th scope="col">Amount</th>
          <th scope="col">Request Date</th>
          <th scope="col">Start Date</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($r = mysqli_fetch_array($res)) {
        ?>
          <tr>
            <td><?php echo $r["requestid"]; ?></td>
            <td><?php echo $r["customername"]; ?></td>
            <td><?php echo $r["contactno"]; ?></td>
            <td><?php echo $r["email"]; ?></td>
            <td><?php echo $r["subname"]; ?></td>
            <td><?php echo $r["amount"]; ?></td>
            <td><?php echo $r["date"]; ?></td>
            <td><?php echo $r["startdate"]; ?></td>
            <td><?php echo ucfirst($r["status"]); ?></td>
            <td>
              <a href="updaterequest.php?rid=<?php echo $r['requestid']; ?>&status=accepted" class="btn btn-success btn-sm">Approve</a>
              <a href="updaterequest.php?rid=<?php echo $r['requestid']; ?>&status=rejected" class="btn btn-danger btn-sm">Reject</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div></div>

<?php
include('footer.php');
?>