<?php
include("../dboperation.php"); 
$obj = new dboperation();

$requests = [];
$from = $to = '';

if (isset($_POST['filter'])) {
    $from = $_POST['fromdate'];
    $to   = $_POST['todate'];

    // ✅ Query: filter product booking requests between selected dates
    $sql = "SELECT r.requestid, r.date, r.status,
                   c.customername, c.contact_num, c.c_email,
                   p.product_name
            FROM tbl_request r
            INNER JOIN tbl_customer c ON r.customer_id = c.customer_id
            INNER JOIN tbl_subscription p  ON r.subscription id  = p.subscription id
            WHERE r.date BETWEEN '$from' AND '$to'
            ORDER BY r.date ASC";

    $res = $obj->executequery($sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $requests[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Booking Request Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4 text-center">Product Booking Request Report</h2>

  <!-- Filter Form -->
  <form method="post" class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">From Date</label>
      <input type="date" name="fromdate" class="form-control" value="<?php echo $from; ?>" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">To Date</label>
      <input type="date" name="todate" class="form-control" value="<?php echo $to; ?>" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
      <button type="submit" name="filter" class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <?php if (!empty($requests)) { ?>
    <!-- Export to Excel Button -->
    <form method="post" action="export_excel.php">
      <input type="hidden" name="fromdate" value="<?php echo $from; ?>">
      <input type="hidden" name="todate" value="<?php echo $to; ?>">
      <button type="submit" class="btn btn-success mb-4">Export to Excel</button>
    </form>

    <!-- Results Table -->
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Request ID</th>
          <th>Customer Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Request Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $req) { ?>
          <tr>
            <td><?php echo $req['subscriptionid']; ?></td>
            <td><?php echo $req['customername']; ?></td>
            <td><?php echo $req['contact_num']; ?></td>
            <td><?php echo $req['c_email']; ?></td>
            <td><?php echo $req['product_name']; ?></td>
            <td><?php echo $req['quantity']; ?></td>
            <td><?php echo $req['booked_date']; ?></td>
            <td><?php echo $req['status']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } elseif (isset($_POST['filter'])) { ?>
    <p class="text-center text-danger">No booking requests found in this date range.</p>
  <?php } ?>
</div>

</body>
</html>


