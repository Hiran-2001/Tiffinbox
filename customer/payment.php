<?php 
include 'header.php';
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["customerid"])) {
    echo "<script>alert('Please login to make payment.'); window.location='login.php'</script>";
    exit();
}

// Check if request ID is provided
if(!isset($_GET['rid']) || empty($_GET['rid'])) {
    echo "<script>alert('Invalid request.'); window.location='orders.php'</script>";
    exit();
}

$obj = new dboperation();
$requestid = $_GET['rid'];
$customerid = $_SESSION["customerid"];

// Get order details
$order_query = "SELECT r.requestid, r.subscriptionid, r.startdate, r.status, 
                c.customername, c.contactno, c.email, c.housename, c.landmark, c.pincode,
                s.subname, s.day, s.amount, s.description
                FROM tbl_request r 
                LEFT JOIN tbl_customer c ON r.customerid = c.customerid
                LEFT JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid 
                WHERE r.requestid = '$requestid' AND r.customerid = '$customerid' AND r.status = 'Accepted'";

$result = $obj->executequery($order_query);

if(mysqli_num_rows($result) == 0) {
    echo "<script>alert('Order not found or not yet accepted by admin.'); window.location='orders.php'</script>";
    exit();
}

$order = mysqli_fetch_array($result);
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Payment</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="orders.php">Orders</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Payment</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Payment Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Complete Payment</h5>
                    <h1 class="mb-5">Order Payment Details</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">
                                    <i class="fa fa-credit-card me-2"></i>Payment for Order #<?php echo $order['requestid']; ?>
                                </h4>
                            </div>
                            
                            <div class="card-body">
                                <!-- Order Summary -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="fa fa-receipt me-2"></i>Order Summary
                                        </h5>
                                        <div class="bg-light p-3 rounded">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Subscription Plan:</strong><br>
                                                    <span class="text-primary fs-5"><?php echo $order['subname']; ?></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Duration:</strong><br>
                                                    <span><?php echo $order['day']; ?> Day(s)</span>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <strong>Description:</strong><br>
                                                    <span><?php echo $order['description']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Customer Details -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="fa fa-user me-2"></i>Customer Information
                                        </h5>
                                        <div class="bg-light p-3 rounded">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>Name:</strong> <?php echo $order['customername']; ?><br>
                                                    <strong>Contact:</strong> <?php echo $order['contactno']; ?><br>
                                                    <strong>Email:</strong> <?php echo $order['email']; ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Address:</strong><br>
                                                    <?php echo $order['housename']; ?>, <?php echo $order['landmark']; ?><br>
                                                    Pincode: <?php echo $order['pincode']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Payment Details -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="fa fa-money-bill me-2"></i>Payment Details
                                        </h5>
                                        <div class="bg-success text-white p-4 rounded text-center">
                                            <h2 class="mb-2">Total Amount</h2>
                                            <h1 class="display-4">₹<?php echo $order['amount']; ?></h1>
                                            <p class="mb-0">Start Date: <?php echo date('M d, Y', strtotime($order['startdate'])); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Form -->
                                <form action="payment_action.php" method="POST">
                                    <input type="hidden" name="requestid" value="<?php echo $order['requestid']; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $order['amount']; ?>">
                                    <input type="hidden" name="customerid" value="<?php echo $customerid; ?>">
                                    
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fa fa-credit-card me-2"></i>Payment Method
                                            </h5>
                                            
                                            <!-- Debit Card Option -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="debitcard" value="Debit Card" checked>
                                                <label class="form-check-label" for="debitcard">
                                                    <i class="fa fa-credit-card me-2"></i>Debit Card
                                                </label>
                                            </div>
                                            
                                            <!-- Debit Card Details -->
                                            <div id="debitCardDetails" class="payment-details bg-light p-3 rounded mb-3">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="cardNumber" class="form-label">Card Number</label>
                                                        <input type="text" class="form-control" id="cardNumber" name="card_number" 
                                                               placeholder="1234 5678 9012 3456" maxlength="19">
                                                    </div>
                                                    <div class="col-md-8 mb-3">
                                                        <label for="cardName" class="form-label">Cardholder Name</label>
                                                        <input type="text" class="form-control" id="cardName" name="card_name" 
                                                               placeholder="Name on Card">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="cardExpiry" class="form-label">Expiry Date</label>
                                                        <input type="text" class="form-control" id="cardExpiry" name="card_expiry" 
                                                               placeholder="MM/YY" maxlength="5">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="cardCvv" class="form-label">CVV</label>
                                                        <input type="password" class="form-control" id="cardCvv" name="card_cvv" 
                                                               placeholder="123" maxlength="3">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- GPay Option -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="payment_method" id="gpay" value="GPay">
                                                <label class="form-check-label" for="gpay">
                                                    <i class="fa fa-google me-2"></i>Google Pay (GPay)
                                                </label>
                                            </div>
                                            
                                            <!-- GPay Details -->
                                            <div id="gpayDetails" class="payment-details bg-light p-3 rounded mb-3" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="gpayNumber" class="form-label">GPay Mobile Number</label>
                                                        <input type="tel" class="form-control" id="gpayNumber" name="gpay_number" 
                                                               placeholder="Enter your GPay registered mobile number">
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="alert alert-info">
                                                            <i class="fa fa-info-circle me-2"></i>
                                                            You will receive a payment request on your GPay app. Please accept it to complete the payment.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="terms" required>
                                                <label class="form-check-label" for="terms">
                                                    I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and confirm the payment details are correct.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Buttons -->
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-success btn-lg me-3">
                                                <i class="fa fa-lock me-2"></i>Pay ₹<?php echo $order['amount']; ?>
                                            </button>
                                            <a href="orders.php" class="btn btn-outline-secondary btn-lg">
                                                <i class="fa fa-times me-2"></i>Cancel
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Payment End -->

        <script>
        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        
        // Payment method change handler
        document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Hide all payment details
                document.querySelectorAll('.payment-details').forEach(function(details) {
                    details.style.display = 'none';
                });
                
                // Show relevant payment details
                if (this.value === 'Debit Card') {
                    document.getElementById('debitCardDetails').style.display = 'block';
                } else if (this.value === 'GPay') {
                    document.getElementById('gpayDetails').style.display = 'block';
                }
            });
        });
        
        // Card number formatting
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedInputValue = value.match(/.{1,4}/g)?.join(' ') || '';
            if (formattedInputValue.length > 19) {
                formattedInputValue = formattedInputValue.substring(0, 19);
            }
            e.target.value = formattedInputValue;
        });
        
        // Expiry date formatting
        document.getElementById('cardExpiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
        
        // CVV validation
        document.getElementById('cardCvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
        
        // GPay number validation
        document.getElementById('gpayNumber').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            if (e.target.value.length > 10) {
                e.target.value = e.target.value.substring(0, 10);
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            if (paymentMethod === 'Debit Card') {
                let cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
                let cardName = document.getElementById('cardName').value.trim();
                let cardExpiry = document.getElementById('cardExpiry').value;
                let cardCvv = document.getElementById('cardCvv').value;
                
                if (cardNumber.length !== 16) {
                    alert('Please enter a valid 16-digit card number.');
                    e.preventDefault();
                    return;
                }
                if (cardName === '') {
                    alert('Please enter cardholder name.');
                    e.preventDefault();
                    return;
                }
                if (cardExpiry.length !== 5) {
                    alert('Please enter expiry date in MM/YY format.');
                    e.preventDefault();
                    return;
                }
                if (cardCvv.length !== 3) {
                    alert('Please enter a valid 3-digit CVV.');
                    e.preventDefault();
                    return;
                }
            } else if (paymentMethod === 'GPay') {
                let gpayNumber = document.getElementById('gpayNumber').value;
                if (gpayNumber.length !== 10) {
                    alert('Please enter a valid 10-digit mobile number.');
                    e.preventDefault();
                    return;
                }
            }
        });
        </script>

<?php include 'footer.php'; ?>