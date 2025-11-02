<?php
include_once("../dboperation.php");
$obj = new dboperation();

// ✅ Get Paid Bookings Count per Product
$sql = "SELECT p.subname, COUNT(b.requestid) AS paid_bookings
        FROM tbl_subscription p
        JOIN tbl_request b ON p.subscriptionid = b.subscriptionid
        WHERE b.status = 'paid'
        GROUP BY p.subscriptionid";

$result = $obj->executequery($sql);

$labels = [];
$counts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['subname'];
    $counts[] = $row['paid_bookings'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Paid Bookings Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2 align="center">Paid Bookings (Product-wise)</h2>
    <div style="width:30%; margin:auto;">
        <canvas id="paidBookingsChart"></canvas>
    </div>

    <script>
        new Chart(document.getElementById("paidBookingsChart"), {
            type: "pie",
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: [
                        '#FF6384','#36A2EB','#FFCE56','#4BC0C0',
                        '#9966FF','#FF9F40','#2ECC71','#8E44AD'
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: { position: "bottom" }
                }
            }
        });
    </script>
</body>
</html>


