<?php 
include 'header.php';
include_once("../dboperation.php");

// If user is already logged in, redirect to index
if(isset($_SESSION["name"])) {
    echo "<script>window.location='index.php'</script>";
    exit();
}
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Sign Up</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Sign Up</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Signup Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Create Account</h5>
                    <h1 class="mb-5">Join BiteBox Today</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">
                                    <i class="fa fa-user-plus me-2"></i>Delivery Boy Registration
                                </h4>
                            </div>
                            
                            <div class="card-body">
                                <form action="signup_action.php" method="POST">
                                    <!-- Personal Information -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fa fa-info-circle me-2"></i>Personal Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" id="customername" name="name" 
                                                   placeholder="Enter your full name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   placeholder="Enter your email" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone *</label>
                                            <input type="tel" class="form-control" id="contactno" name="phone" 
                                                   placeholder="Enter your phone number" required>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Address Information -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fa fa-map-marker-alt me-2"></i>Address Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="houseno" class="form-label">House Name/Number *</label>
                                            <input type="text" class="form-control" id="housename" name="houseno" 
                                                   placeholder="Enter house name/number" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="landmark" class="form-label">Landmark *</label>
                                            <input type="text" class="form-control" id="landmark" name="landmark" 
                                                   placeholder="Enter landmark" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pincode" class="form-label">Pincode *</label>
                                            <input type="text" class="form-control" id="pincode" name="pincode" 
                                                   placeholder="Enter pincode" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="locationid" class="form-label">Location *</label>
                                            <select class="form-control" id="locationid" name="locationid" required>
                                                <option value="">Select Location</option>
                                                <?php
                                                $obj = new dboperation();
                                                $location_query = "SELECT * FROM tbl_location";
                                                $location_result = $obj->executequery($location_query);
                                                while($location = mysqli_fetch_array($location_result)) {
                                                    echo "<option value='" . $location['locationid'] . "'>" . $location['locationname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="districtid" class="form-label">District *</label>
                                            <select class="form-control" id="districtid" name="districtid" required>
                                                <option value="">Select District</option>
                                                <?php
                                                $obj = new dboperation();
                                                $district_query = "SELECT * FROM tbl_district";
                                                $district_result = $obj->executequery($district_query);
                                                while($district = mysqli_fetch_array($district_result)) {
                                                    echo "<option value='" . $district['districtid'] . "'>" . $district['districtname'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Login Credentials -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fa fa-lock me-2"></i>Login Credentials
                                            </h5>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">Username *</label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   placeholder="Choose a username" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Choose a password" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password *</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Confirm your password" required>
                                        </div>
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-lg me-3">
                                                <i class="fa fa-user-plus me-2"></i>Create Account
                                            </button>
                                            <a href="login.php" class="btn btn-outline-secondary btn-lg">
                                                <i class="fa fa-sign-in-alt me-2"></i>Already have account? Login
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
        <!-- Signup End -->

        <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        </script>

<?php include 'footer.php'; ?>