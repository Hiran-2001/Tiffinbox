<?php 
include 'header.php';
include_once("../dboperation.php");

$obj = new dboperation();

// Get all active subscriptions
$subscriptionQuery = "SELECT s.*, c.category_name FROM tbl_subscription s 
                     JOIN tbl_category c ON s.categoryid = c.categoryid 
                     ORDER BY s.subscriptionid";
$subscriptionResult = $obj->executequery($subscriptionQuery);
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Subscription Plans</h1>
                    <p class="text-white mb-3">Choose from our carefully crafted meal subscription plans</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Subscriptions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Subscriptions Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Our Plans</h5>
                    <h1 class="mb-5">Choose Your Perfect Plan</h1>
                </div>

                <div class="row">
                    <?php 
                    if(mysqli_num_rows($subscriptionResult) > 0) {
                        while($subscription = mysqli_fetch_array($subscriptionResult)) {
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm hover-card">
                            <img src="../uploads/<?php echo $subscription['image']; ?>" class="card-img-top" alt="<?php echo $subscription['subname']; ?>" style="height: 250px; object-fit: cover;" onerror="this.src='img/menu-1.jpg'">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title text-primary"><?php echo $subscription['subname']; ?></h5>
                                    <span class="badge bg-secondary"><?php echo $subscription['category_name']; ?></span>
                                </div>
                                
                                <p class="card-text flex-grow-1"><?php echo substr($subscription['description'], 0, 120); ?>...</p>
                                
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Duration</small>
                                            <div class="fw-bold"><?php echo $subscription['day']; ?> Day(s)</div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small class="text-muted">Price</small>
                                            <div class="h5 text-success mb-0">₹<?php echo $subscription['amount']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="menu.php?plan=<?php echo $subscription['subscriptionid']; ?>" class="btn btn-outline-primary">
                                        <i class="fa fa-eye me-2"></i>View Menu
                                    </a>
                                    <button class="btn btn-primary" onclick="bookSubscription(<?php echo $subscription['subscriptionid']; ?>)">
                                        <i class="fa fa-shopping-cart me-2"></i>Subscribe Now
                                    </button>
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
                            <i class="fa fa-utensils fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Subscription Plans Available</h4>
                            <p class="text-muted">Please check back later for available plans.</p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Subscriptions End -->

        <style>
        .hover-card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        </style>

        <script>
        function bookSubscription(subscriptionId) {
            <?php if(isset($_SESSION["username"])): ?>
                // Redirect to booking page
                window.location.href = 'booking.php?plan=' + subscriptionId;
            <?php else: ?>
                alert('Please login to book a subscription plan.');
                window.location.href = 'login.php';
            <?php endif; ?>
        }

        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        </script>

<?php include 'footer.php'; ?>