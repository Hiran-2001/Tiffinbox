<?php 
include 'header.php';
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["deliverypersonid"])) {
    echo "<script>alert('Please login to edit your profile.'); window.location='login.php'</script>";
    exit();
}

$obj = new dboperation();
$deliverypersonid = $_SESSION["deliverypersonid"];

// Get customer profile information
$sqlquery = "SELECT * FROM tbl_deliveryperson WHERE deliverypersonid = '$deliverypersonid'";
$result = $obj->executequery($sqlquery);
$deliveryperson = mysqli_fetch_array($result);
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Edit Profile</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Edit Profile Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Update Profile</h5>
                    <h1 class="mb-5">Edit Your Information</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">
                                    <i class="fa fa-edit me-2"></i>Edit Profile Information
                                </h4>
                            </div>
                            
                            <div class="card-body">
                                <form action="edit_profile_action.php" method="POST">
                                    <!-- Personal Information -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fa fa-info-circle me-2"></i>Personal Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?php echo $deliveryperson['name']; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?php echo $deliveryperson['username']; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?php echo $deliveryperson['email']; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Contact Number</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" 
                                                   value="<?php echo $deliveryperson['phone']; ?>" required>
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
                                            <label for="houseno" class="form-label">House Name/Number</label>
                                            <input type="text" class="form-control" id="houseno" name="houseno" 
                                                   value="<?php echo $deliveryperson['houseno']; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="landmark" class="form-label">Landmark</label>
                                            <input type="text" class="form-control" id="landmark" name="landmark" 
                                                   value="<?php echo $deliveryperson['landmark']; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="text" class="form-control" id="pincode" name="pincode" 
                                                   value="<?php echo $deliveryperson['pincode']; ?>" required>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Password Change -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fa fa-lock me-2"></i>Change Password (Optional)
                                            </h5>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Leave blank to keep current password">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Confirm new password">
                                        </div>
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-lg me-3">
                                                <i class="fa fa-save me-2"></i>Save Changes
                                            </button>
                                            <a href="profile.php" class="btn btn-outline-secondary btn-lg">
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
        <!-- Edit Profile End -->

        <script>
        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== '' && confirmPassword !== '' && password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        </script>

<?php include 'footer.php'; ?>