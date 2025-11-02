<?php
include_once("../dboperation.php");
$obj = new dboperation();

// ✅ Fetch total payment amount per month with readable names
$sql = "SELECT DATE_FORMAT(paymentdate, '%b %Y') AS month, 
               SUM(amount) AS amount
        FROM tbl_payment
        WHERE status = 'paid'
        GROUP BY DATE_FORMAT(paymentdate, '%Y-%m')
        ORDER BY MIN(paymentdate)";

$result = $obj->executequery($sql);

$months = [];
$amounts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $amounts[] = $row['amount'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Monthly Payment Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2 align="center">Total Payment Amount (Month-wise)</h2>
    <div style="width:70%; margin:auto;">
        <canvas id="monthlyPaymentChart"></canvas>
    </div>

    <script>
        new Chart(document.getElementById("monthlyPaymentChart"), {
            type: "bar",
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: "Total Amount",
                    data: <?php echo json_encode($amounts); ?>,
                    backgroundColor: "rgba(54, 162, 235, 0.7)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</body>
</html>
