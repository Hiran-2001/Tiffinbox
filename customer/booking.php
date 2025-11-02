<?php 
include 'header.php';
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["customerid"])) {
    echo "<script>alert('Please login to book a subscription.'); window.location='login.php'</script>";
    exit();
}

$obj = new dboperation();
$customerid = $_SESSION["customerid"];

// Get subscription ID from URL parameter
$subscriptionId = isset($_GET['plan']) ? intval($_GET['plan']) : 0;

if($subscriptionId == 0) {
    echo "<script>alert('Invalid subscription plan.'); window.location='index.php'</script>";
    exit();
}

// Fetch subscription details
$subscriptionQuery = "SELECT s.*, c.category_name FROM tbl_subscription s 
                     JOIN tbl_category c ON s.categoryid = c.categoryid 
                     WHERE s.subscriptionid = $subscriptionId";
$subscriptionResult = $obj->executequery($subscriptionQuery);
$subscription = mysqli_fetch_assoc($subscriptionResult);

if(!$subscription) {
    echo "<script>alert('Subscription plan not found.'); window.location='index.php'</script>";
    exit();
}

// Get customer details
$customerQuery = "SELECT * FROM tbl_customer WHERE customerid = $customerid";
$customerResult = $obj->executequery($customerQuery);
$customer = mysqli_fetch_assoc($customerResult);
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Book Subscription</h1>
                    <p class="text-white mb-3"><?php echo $subscription['subname']; ?> Plan - <?php echo $subscription['category_name']; ?> Category</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="menu.php?plan=<?php echo $subscriptionId; ?>">Menu</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Booking Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Place Your Order</h5>
                    <h1 class="mb-5">Book Your Subscription</h1>
                </div>

                <div class="row justify-content-center">
                    <!-- Subscription Summary -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow">
                            <img src="../uploads/<?php echo $subscription['image']; ?>" class="card-img-top" alt="<?php echo $subscription['subname']; ?>" style="height: 200px; object-fit: cover;" onerror="this.src='img/menu-1.jpg'">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?php echo $subscription['subname']; ?> Plan</h5>
                                <p class="card-text"><?php echo $subscription['description']; ?></p>
                                <div class="mb-2">
                                    <strong class="text-muted">Category:</strong> <?php echo $subscription['category_name']; ?>
                                </div>
                                <div class="mb-2">
                                    <strong class="text-muted">Duration:</strong> <?php echo $subscription['day']; ?> Day(s)
                                </div>
                                <div class="mb-3">
                                    <h4 class="text-success">₹<?php echo $subscription['amount']; ?></h4>
                                </div>
                                <a href="menu.php?plan=<?php echo $subscriptionId; ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-eye me-1"></i>View Meal Plan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="col-lg-8 col-md-6">
                        <div class="card shadow">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-4">
                                    <i class="fa fa-user-circle me-2 text-primary"></i>Booking Details
                                </h5>

                                <form method="POST" action="bookingaction.php" id="bookingForm">
                                    <input type="hidden" name="subscriptionid" value="<?php echo $subscriptionId; ?>">

                                    <!-- Customer Information (Read-only) -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" class="form-control" value="<?php echo $customer['customername']; ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" class="form-control" value="<?php echo $customer['contactno']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="<?php echo $customer['email']; ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">House Name/Number</label>
                                            <input type="text" class="form-control" value="<?php echo $customer['housename']; ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Subscription Details -->
                                    <hr class="my-4">
                                    <h6 class="text-primary mb-3">Subscription Information</h6>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Plan Name</label>
                                            <input type="text" class="form-control" value="<?php echo $subscription['subname']; ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Duration</label>
                                            <input type="text" class="form-control" value="<?php echo $subscription['day']; ?> Day(s)" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Category</label>
                                            <input type="text" class="form-control" value="<?php echo $subscription['category_name']; ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Total Amount</label>
                                            <input type="text" class="form-control text-success fw-bold" value="₹<?php echo $subscription['amount']; ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Booking Specific Fields -->
                                    <hr class="my-4">
                                    <h6 class="text-primary mb-3">Booking Information</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="startdate">
                                                <i class="fa fa-calendar me-1"></i>Start Date <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control" id="startdate" name="startdate" required min="<?php echo date('Y-m-d'); ?>">
                                            <small class="form-text text-muted">Select when you want your subscription to start</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Order Date</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                                        </div>
                                    </div>

                                    <hr class="my-4">
                                    <h6 class="text-primary mb-3">Delivery Address</h6>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="delivery_name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Delivery Contact <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="delivery_contact" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">District <span class="text-danger">*</span></label>
                                            <select class="form-control" name="delivery_district" id="district_id" required>
                                                <option value="">Select District</option>
                                                <?php
                                                $district_query = "SELECT * FROM tbl_district";
                                                $district_result = $obj->executequery($district_query);
                                                while($district = mysqli_fetch_assoc($district_result)) {
                                                    echo "<option value='".$district['districtid']."'>".$district['districtname']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location <span class="text-danger">*</span></label>
                                            <select class="form-control" name="delivery_location" id="location" required>
                                                <option value="">Select District First</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">House Number <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="delivery_houseno" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="delivery_pincode" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Landmark <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="delivery_landmark" required>
                                        </div>
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and confirm that all information provided is correct.
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="menu.php?plan=<?php echo $subscriptionId; ?>" class="btn btn-outline-secondary w-100">
                                                <i class="fa fa-arrow-left me-2"></i>Back to Menu
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary w-100" name="book_subscription">
                                                <i class="fa fa-check-circle me-2"></i>Confirm Booking
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking End -->

        <script src="../jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function () {
            $("#district_id").change(function () {
                var district_id = $(this).val();
                $.ajax({
                    url: "getlocation.php",
                    method: "POST",
                    data: { districtid: district_id },
                    success: function (response) {
                        $("#location").html(response);
                    },
                    error: function () {
                        $("#location").html("<option>Error loading locations</option>");
                    }
                });
            });
        });

        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const startDate = document.getElementById('startdate').value;
            const termsChecked = document.getElementById('terms').checked;
            const deliveryName = document.querySelector('input[name="delivery_name"]').value;
            const deliveryContact = document.querySelector('input[name="delivery_contact"]').value;
            const deliveryDistrict = document.querySelector('select[name="delivery_district"]').value;
            const deliveryLocation = document.querySelector('select[name="delivery_location"]').value;
            const deliveryHouseno = document.querySelector('input[name="delivery_houseno"]').value;
            const deliveryPincode = document.querySelector('input[name="delivery_pincode"]').value;
            const deliveryLandmark = document.querySelector('input[name="delivery_landmark"]').value;
            
            if (!startDate) {
                e.preventDefault();
                alert('Please select a start date for your subscription.');
                return false;
            }
            
            if (!deliveryName || !deliveryContact || !deliveryDistrict || !deliveryLocation || !deliveryHouseno || !deliveryPincode || !deliveryLandmark) {
                e.preventDefault();
                alert('Please fill all delivery address fields including district and location.');
                return false;
            }
            
            if (!termsChecked) {
                e.preventDefault();
                alert('Please accept the terms and conditions to proceed.');
                return false;
            }
            
            const confirmBooking = confirm('Are you sure you want to book this subscription plan?');
            if (!confirmBooking) {
                e.preventDefault();
                return false;
            }
        });

        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        </script>

<?php include 'footer.php'; ?>