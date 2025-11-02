<?php
include 'header.php';
include '../dboperation.php';
$db = new dboperation();

// Get subscription ID from URL parameter
$subscriptionId = isset($_GET['plan']) ? intval($_GET['plan']) : 0;

// Fetch subscription details
$subscriptionQuery = "SELECT s.*, c.category_name FROM tbl_subscription s 
                     JOIN tbl_category c ON s.categoryid = c.categoryid 
                     WHERE s.subscriptionid = $subscriptionId";
$subscriptionResult = $db->executequery($subscriptionQuery);
$subscription = mysqli_fetch_assoc($subscriptionResult);

// Fetch meal plan details for this subscription
$mealPlanQuery = "SELECT mpd.*, f.foodname, f.image, f.price, mt.typename as mealtype_name
                 FROM tbl_mealplandetails mpd 
                 JOIN tbl_fooditem f ON mpd.foodid = f.foodid 
                 JOIN tbl_mealtype mt ON mpd.mealtypeid = mt.mealtypeid
                 WHERE mpd.subscriptionid = $subscriptionId
                 ORDER BY mpd.daynum, mpd.mealtypeid";
$mealPlanResult = $db->executequery($mealPlanQuery);
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <?php if ($subscription): ?>
                    <h1 class="display-3 text-white mb-3 animated slideInDown"><?php echo $subscription['subname']; ?> Plan</h1>
                    <p class="text-white mb-3"><?php echo $subscription['category_name']; ?> Category | <?php echo $subscription['day']; ?> Days | ₹<?php echo $subscription['amount']; ?></p>
                    <?php else: ?>
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Food Menu</h1>
                    <?php endif; ?>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Menu Plan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Menu Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <?php if (!$subscription): ?>
                <div class="text-center">
                    <h3 class="text-danger">No subscription plan found</h3>
                    <p>Please select a valid subscription plan from our <a href="index.php" class="text-primary">home page</a>.</p>
                </div>
                <?php else: ?>
                
                <!-- Subscription Info -->
                <div class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Meal Plan Details</h5>
                    <h1 class="mb-3"><?php echo $subscription['subname']; ?> Subscription</h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="bg-light p-4 rounded">
                                <p class="mb-2"><strong>Description:</strong> <?php echo $subscription['description']; ?></p>
                                <p class="mb-2"><strong>Duration:</strong> <?php echo $subscription['day']; ?> Days</p>
                                <p class="mb-0"><strong>Total Amount:</strong> ₹<?php echo $subscription['amount']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Meal Plans by Days -->
                <?php
                // Group meal plans by day
                $mealPlans = [];
                if (mysqli_num_rows($mealPlanResult) > 0) {
                    while ($plan = mysqli_fetch_assoc($mealPlanResult)) {
                        $mealPlans[$plan['daynum']][$plan['mealtype_name']][] = $plan;
                    }
                }
                ?>

                <?php if (empty($mealPlans)): ?>
                <div class="text-center">
                    <h4 class="text-muted">No meal plan details available for this subscription yet.</h4>
                </div>
                <?php else: ?>
                
                <?php foreach ($mealPlans as $dayNum => $dayMeals): ?>
                <div class="mb-5">
                    <div class="text-center mb-4">
                        <h3 class="text-primary">Day <?php echo $dayNum; ?></h3>
                    </div>
                    
                    <div class="row g-4">
                        <?php foreach ($dayMeals as $mealType => $meals): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="meal-section h-100 p-4 bg-light rounded">
                                <div class="text-center mb-3">
                                    <h5 class="text-primary mb-3">
                                        <?php if ($mealType == 'Breakfast'): ?>
                                        <i class="fa fa-coffee me-2"></i>
                                        <?php elseif ($mealType == 'Lunch'): ?>
                                        <i class="fa fa-hamburger me-2"></i>
                                        <?php else: ?>
                                        <i class="fa fa-utensils me-2"></i>
                                        <?php endif; ?>
                                        <?php echo $mealType; ?>
                                    </h5>
                                </div>
                                
                                <?php foreach ($meals as $meal): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <img class="flex-shrink-0 img-fluid rounded me-3" 
                                         src="../uploads/<?php echo $meal['image']; ?>" 
                                         alt="<?php echo $meal['foodname']; ?>" 
                                         style="width: 60px; height: 60px; object-fit: cover;"
                                         onerror="this.src='img/menu-1.jpg'">
                                    <div class="w-100">
                                        <h6 class="mb-1"><?php echo $meal['foodname']; ?></h6>
                                        <small class="text-primary">₹<?php echo $meal['price']; ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <!-- Action Buttons -->
                <div class="text-center mt-5">
                    <a href="index.php" class="btn btn-outline-primary me-3">← Back to Categories</a>
                    <button class="btn btn-primary" onclick="bookSubscription(<?php echo $subscriptionId; ?>)">
                        Subscribe to this Plan
                    </button>
                </div>
                
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <style>
        .meal-section {
            border-left: 4px solid #FEA116;
            transition: all 0.3s ease;
        }
        .meal-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        </style>

        <script>
        function bookSubscription(subscriptionId) {
            // Check if user is logged in (you can add this check via PHP session)
            <?php if(isset($_SESSION["username"])): ?>
                // Redirect to booking page
                window.location.href = 'booking.php?plan=' + subscriptionId;
            <?php else: ?>
                alert('Please login to book a subscription plan.');
                window.location.href = 'login.php';
            <?php endif; ?>
        }
        </script>
        <!-- Menu End -->
<?php
include 'footer.php';
?>