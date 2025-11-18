<?php 
include 'header.php';
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["deliverypersonid"])) {
    echo "<script>alert('Please login to view your profile.'); window.location='login.php'</script>";
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
                    <h1 class="display-3 text-white mb-3 animated slideInDown">My Profile</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Profile Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Delivery Person Profile</h5>
                    <h1 class="mb-5">Your Account Information</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Profile Card -->
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="mb-0">
                                            <i class="fa fa-user me-2"></i><?php echo $deliveryperson['name']; ?>
                                        </h4>
                                        <small>Delivery Person ID: #<?php echo $deliveryperson['deliverypersonid']; ?></small>
                                    </div>
                                    <div class="col-auto">
                                        <a href="edit_profile.php" class="btn btn-light btn-sm">
                                            <i class="fa fa-edit me-1"></i>Edit Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <!-- Personal Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="text-primary mb-3">
                                            <i class="fa fa-info-circle me-2"></i>Personal Information
                                        </h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-muted d-block">Full Name</strong>
                                        <span><?php echo $deliveryperson['name']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-muted d-block">Username</strong>
                                        <span><?php echo $deliveryperson['username']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-muted d-block">Email Address</strong>
                                        <span><?php echo $deliveryperson['email']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-muted d-block">Contact Number</strong>
                                        <span><?php echo $deliveryperson['phone']; ?></span>
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
                                        <strong class="text-muted d-block">House Name/Number</strong>
                                        <span><?php echo $deliveryperson['houseno']; ?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-muted d-block">Landmark</strong>
                                        <span><?php echo $deliveryperson['landmark']; ?></span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <strong class="text-muted d-block">Pincode</strong>
                                        <span><?php echo $deliveryperson['pincode']; ?></span>
                                    </div>
                                </div>


                            </div>
                            
                            <!-- <div class="card-footer bg-light">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="orders.php" class="btn btn-outline-primary">
                                            <i class="fa fa-shopping-cart me-2"></i>View My Orders
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <a href="index.php" class="btn btn-primary">
                                            <i class="fa fa-utensils me-2"></i>Browse Menu
                                        </a>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile End -->

        <script>
        // Auto hide spinner
        window.addEventListener('load', function() {
            document.getElementById('spinner').classList.remove('show');
        });
        </script>

<?php include 'footer.php'; ?>