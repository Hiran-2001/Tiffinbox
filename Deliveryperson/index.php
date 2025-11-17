<?php
include 'header.php';
include '../dboperation.php';
$db = new dboperation();

$isLoggedIn = true; // This should be replaced with actual session check
$deliveryPersonId = 3; // This should come from session
$deliveryPersonName = isset($_SESSION["username"]); // This should come from session

if ($isLoggedIn) {
    // Fetch assigned delivery requests for this delivery person
    $assignedQuery = "SELECT r.*, c.customername, c.contactno, s.subname, s.amount 
                      FROM tbl_request r
                      INNER JOIN tbl_customer c ON r.customerid = c.customerid
                      INNER JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid
                      WHERE r.delivarypersonid = '$deliveryPersonId' 
                      AND r.status IN ('Assigned', 'Paid')
                      ORDER BY r.startdate ASC";
    $assignedDeliveries = $db->executequery($assignedQuery);

    // Fetch pending delivery requests (not yet assigned to anyone)
    $pendingQuery = "SELECT r.*, c.customername, c.contactno, s.subname, s.amount 
                     FROM tbl_request r
                     INNER JOIN tbl_customer c ON r.customerid = c.customerid
                     INNER JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid
                     WHERE (r.delivarypersonid IS NULL OR r.delivarypersonid = 0) 
                     AND r.status = 'Paid'
                     ORDER BY r.startdate ASC";
    $pendingDeliveries = $db->executequery($pendingQuery);
}
?>

<div class="container-xxl py-5 bg-dark hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-8 text-center text-lg-start">
                <h1 class="display-4 text-white animated slideInLeft">
                    <i class="fa fa-truck me-3"></i>Delivery Dashboard
                </h1>
                <p class="text-white animated slideInLeft mb-4 pb-2">
                    Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>! Manage your delivery
                    assignments and view available requests.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <div class="card bg-light shadow">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">
                            <i class="fa fa-tachometer-alt me-2"></i>Quick Stats
                        </h5>
                        <div class="row">
                            <div class="col-6">
                                <h4 class="text-success mb-0">
                                    <?php echo mysqli_num_rows($assignedDeliveries ?? mysqli_query($db->conn, "SELECT 1")); ?>
                                </h4>
                                <small class="text-muted">Assigned</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning mb-0">
                                    <?php echo mysqli_num_rows($pendingDeliveries ?? mysqli_query($db->conn, "SELECT 1")); ?>
                                </h4>
                                <small class="text-muted">Available</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Navbar & Hero End -->


<!-- My Assigned Deliveries Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">My Assignments</h5>
            <h1 class="mb-5">Current Delivery Tasks</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <?php if ($isLoggedIn && mysqli_num_rows($assignedDeliveries) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Request ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Subscription</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($delivery = mysqli_fetch_assoc($assignedDeliveries)) { ?>
                                        <tr>
                                            <td><span class="badge bg-primary">#<?php echo $delivery['requestid']; ?></span>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($delivery['customername']); ?></strong></td>
                                            <td>
                                                <i class="fa fa-phone text-primary me-1"></i>
                                                <?php echo htmlspecialchars($delivery['contactno']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($delivery['subname']); ?></td>
                                            <td><span class="text-success fw-bold">₹<?php echo $delivery['amount']; ?></span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($delivery['startdate'])); ?></td>
                                            <td>
                                                <span
                                                    class="badge bg-<?php echo $delivery['status'] == 'Paid' ? 'warning' : 'info'; ?>">
                                                    <?php echo $delivery['status']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm"
                                                    onclick="markDelivered(<?php echo $delivery['requestid']; ?>)">
                                                    <i class="fa fa-check me-1"></i>Mark Delivered
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="text-center py-5">
                            <i class="fa fa-clipboard-list fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted">No Assigned Deliveries</h4>
                            <p class="text-muted">You don't have any delivery assignments at the moment.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- My Assigned Deliveries End -->
<!-- Available Delivery Requests Start -->
<div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Available Requests</h5>
            <h1 class="mb-5">Delivery Requests You Can Accept</h1>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="bg-white rounded h-100 p-4 shadow">
                    <?php if ($isLoggedIn && mysqli_num_rows($pendingDeliveries) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">Request ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">Subscription</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($request = mysqli_fetch_assoc($pendingDeliveries)) { ?>
                                        <tr>
                                            <td><span class="badge bg-secondary">#<?php echo $request['requestid']; ?></span>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($request['customername']); ?></strong></td>
                                            <td>
                                                <i class="fa fa-phone text-primary me-1"></i>
                                                <?php echo htmlspecialchars($request['contactno']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($request['subname']); ?></td>
                                            <td><span class="text-success fw-bold">₹<?php echo $request['amount']; ?></span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($request['startdate'])); ?></td>
                                            <td>
                                                <span class="badge bg-warning">
                                                    Available
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm"
                                                    onclick="acceptDelivery(<?php echo $request['requestid']; ?>)">
                                                    <i class="fa fa-hand-paper me-1"></i>Accept Delivery
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="text-center py-5">
                            <i class="fa fa-clock fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted">No Available Requests</h4>
                            <p class="text-muted">There are no delivery requests available at the moment.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Available Delivery Requests End -->

<!-- Custom Styles and JavaScript -->
<style>
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, .08);
    }

    .badge {
        font-size: 0.8rem;
    }

    .hero-header {
        background: linear-gradient(rgba(15, 23, 43, .9), rgba(15, 23, 43, .9));
    }
</style>
<script>
    function markDelivered(requestId) {
        if (confirm('Are you sure you want to mark this delivery as completed?')) {
            // Here you would typically make an AJAX call to update the database
            // For now, we'll just show an alert and reload the page
            alert('Delivery #' + requestId + ' has been marked as delivered!');
            // In a real implementation, you would make an AJAX call like:
            // fetch('update_delivery_status.php', { method: 'POST', body: 'requestid=' + requestId + '&status=delivered' })
            // .then(() => location.reload());
            location.reload();
        }
    }

    async function acceptDelivery(requestId) {
        console.log('Accepting delivery for request ID:', requestId);
        // if (!confirm('Do you want to accept this delivery request?')) return;

        const form = new FormData();
        form.append('requestid', requestId);
        console.log('Accepting delivery for request ID:', requestId);

        try {
            const resp = await fetch('accept_delivery.php', {
                method: 'POST',
                body: form,
                credentials: "include"
            });
            const data = await resp.json();

            alert(data.message);
            if (data.success) location.reload();
        } catch (e) {
            alert('Network error');
            console.error(e);
        }
    }
</script>

<?php include 'footer.php'; ?>