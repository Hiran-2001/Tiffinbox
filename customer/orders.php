<?php 
include 'header.php';
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["customerid"])) {
    echo "<script>alert('Please login to view your orders.'); window.location='login.php'</script>";
    exit();
}

$obj = new dboperation();
$customerid = $_SESSION["customerid"];

// Get all orders for the logged-in customer
$sqlquery = "SELECT r.requestid, r.subscriptionid, r.startdate, r.status, r.delivarypersonid, 
             s.subname, s.day, s.amount, s.description, s.image,
             p.paymentid, p.paymentdate, p.amount as paid_amount, p.status as payment_status
             FROM tbl_request r 
             LEFT JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid 
             LEFT JOIN tbl_payment p ON r.requestid = p.requestid 
             WHERE r.customerid = '$customerid' 
             ORDER BY r.requestid DESC";

$result = $obj->executequery($sqlquery);
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">My Orders</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Orders Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Order History</h5>
                    <h1 class="mb-5">Your Current Bookings</h1>
                </div>

                <div class="row">
                    <?php 
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            // Get meal plan details for this subscription
                            $subscriptionid = $row['subscriptionid'];
                            $meal_query = "SELECT mpd.daynum, mpd.mealtypeid, f.foodname, mt.typename 
                                          FROM tbl_mealplandetails mpd
                                          LEFT JOIN tbl_fooditem f ON mpd.foodid = f.foodid
                                          LEFT JOIN tbl_mealtype mt ON mpd.mealtypeid = mt.mealtypeid
                                          WHERE mpd.subscriptionid = '$subscriptionid'
                                          ORDER BY mpd.daynum, mpd.mealtypeid";
                            $meal_result = $obj->executequery($meal_query);
                            
                            // Determine status badge color
                            $status_class = '';
                            switch(strtolower($row['status'])) {
                                case 'pending':
                                    $status_class = 'bg-warning';
                                    break;
                                case 'paid':
                                    $status_class = 'bg-success';
                                    break;
                                case 'delivered':
                                    $status_class = 'bg-info';
                                    break;
                                case 'cancelled':
                                    $status_class = 'bg-danger';
                                    break;
                                default:
                                    $status_class = 'bg-secondary';
                            }
                    ?>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="../uploads/<?php echo $row['image']; ?>" class="img-fluid rounded-start h-100" alt="<?php echo $row['subname']; ?>" style="object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title text-primary"><?php echo $row['subname']; ?></h5>
                                            <span class="badge <?php echo $status_class; ?> text-uppercase"><?php echo $row['status']; ?></span>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Order ID: #<?php echo $row['requestid']; ?></small>
                                        </div>
                                        
                                        <p class="card-text"><?php echo !empty($row['description']) ? substr($row['description'], 0, 100) . '...' : 'Delicious meal plan subscription'; ?></p>
                                        
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <strong class="text-success">₹<?php echo $row['amount']; ?></strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small class="text-muted"><?php echo $row['day']; ?> Day(s)</small>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fa fa-calendar me-1"></i>
                                                Start Date: <?php echo date('M d, Y', strtotime($row['startdate'])); ?>
                                            </small>
                                        </div>

                                        <?php if($row['payment_status'] == 'Paid'): ?>
                                        <div class="mb-2">
                                            <small class="text-success">
                                                <i class="fa fa-check-circle me-1"></i>
                                                Paid on <?php echo date('M d, Y', strtotime($row['paymentdate'])); ?>
                                            </small>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#mealPlan<?php echo $row['requestid']; ?>">
                                                <i class="fa fa-eye me-1"></i>View Meal Plan
                                            </button>
                                            <?php if(strtolower($row['status']) == 'accepted'): ?>
                                            <a href="payment.php?rid=<?php echo $row['requestid']; ?>" class="btn btn-success btn-sm">
                                                <i class="fa fa-credit-card me-1"></i>Pay Now
                                            </a>
                                            <?php endif; ?>
                                            <?php if(strtolower($row['status']) == 'pending'): ?>
                                            <button class="btn btn-danger btn-sm" onclick="cancelOrder(<?php echo $row['requestid']; ?>)">
                                                <i class="fa fa-times me-1"></i>Cancel
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Collapsible Meal Plan Details -->
                            <div class="collapse" id="mealPlan<?php echo $row['requestid']; ?>">
                                <div class="card-body border-top">
                                    <h6 class="text-primary mb-3">Meal Plan Details</h6>
                                    <?php 
                                    if(mysqli_num_rows($meal_result) > 0) {
                                        $current_day = '';
                                        while($meal = mysqli_fetch_array($meal_result)) {
                                            if($current_day != $meal['daynum']) {
                                                if($current_day != '') echo '</div>';
                                                echo '<div class="mb-3">';
                                                echo '<h6 class="fw-bold text-dark">Day ' . $meal['daynum'] . '</h6>';
                                                $current_day = $meal['daynum'];
                                            }
                                            echo '<div class="row mb-1">';
                                            echo '<div class="col-4"><small class="text-muted">' . $meal['typename'] . ':</small></div>';
                                            echo '<div class="col-8"><small>' . $meal['foodname'] . '</small></div>';
                                            echo '</div>';
                                        }
                                        if($current_day != '') echo '</div>';
                                    } else {
                                        echo '<p class="text-muted">No meal plan details available.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    } else {
                    ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Orders Found</h4>
                            <p class="text-muted">You haven't placed any orders yet.</p>
                            <a href="index.php" class="btn btn-primary">
                                <i class="fa fa-utensils me-2"></i>Explore Menu
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Orders End -->

        <script>
        function cancelOrder(requestId) {
            if(confirm('Are you sure you want to cancel this order?')) {
                window.location.href = 'cancel_order.php?id=' + requestId;
            }
        }
        
        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        </script>

<?php include 'footer.php'; ?>
