<?php
include("../dboperation.php");
$obj = new dboperation();

$fromDate = $_POST['from_date'] ?? '';
$toDate = $_POST['to_date'] ?? '';

$query = "SELECT r.*, c.customername, s.subname
          FROM tbl_request r
          JOIN tbl_customer c ON r.customerid = c.customerid
          JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid";

if (!empty($fromDate) && !empty($toDate)) {
    $query .= " WHERE r.date BETWEEN '$fromDate' AND '$toDate'";
}

$query .= " ORDER BY r.date ASC";

// Run query only if "View Report" is clicked
if (isset($_POST['view'])) {
    $res = $obj->executequery($query);
}

// ✅ Excel Export Logic
if (isset($_POST['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=datewise_report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $excelQuery = $query;
    $result = $obj->executequery($excelQuery);

    echo "<table border='1'>";
    echo "<tr>
            <th>Request ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Start Date</th>
            <th>Subscription</th>
         
          </tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>{$row['requestid']}</td>
                <td>{$row['customername']}</td>
                <td>{$row['date']}</td>
                <td>{$row['startdate']}</td>
                <td>{$row['subname']}</td>
              
               
              </tr>";
    }
    echo "</table>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Date-wise Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="text-center mb-4 text-primary">Date-wise Request Report</h3>

  <form method="POST" class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">From Date</label>
      <input type="date" name="from_date" class="form-control" required value="<?= $fromDate ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">To Date</label>
      <input type="date" name="to_date" class="form-control" required value="<?= $toDate ?>">
    </div>
    <div class="col-md-4 d-flex align-items-end gap-2">
      <button type="submit" class="btn btn-primary w-50" name="view">View Report</button>
      <button type="submit" class="btn btn-success w-50" name="export_excel">Export to Excel</button>
    </div>
  </form>

  <?php if (isset($_POST['view'])) { ?>
  <table class="table table-bordered table-striped">
    <thead class="table-primary text-center">
      <tr>
        <th>Request ID</th>
        <th>Customer</th>
        <th>Date</th>
        <th>Start Date</th>
        <th>Subscription</th>
 
      
      </tr>
    </thead>
    <tbody>
      <?php
      if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_array($res)) {
          echo "<tr>
                  <td>{$row['requestid']}</td>
                  <td>{$row['customername']}</td>
                  <td>{$row['date']}</td>
                  <td>{$row['startdate']}</td>
                  <td>{$row['subname']}</td>
                
                </tr>";
        }
      } else {
        echo "<tr><td colspan='7' class='text-center text-danger'>No records found for the selected date range</td></tr>";
      }
      ?>
    </tbody>
  </table>
  <?php } ?>
</div>
</body>
</html>
