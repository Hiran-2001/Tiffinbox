<?php 
include 'header.php'; 
include '../dboperation.php';
$db = new dboperation();

// Fetch categories
$categories = $db->executequery("SELECT * FROM tbl_category ORDER BY categoryid");

// Fetch subscriptions with category info
$subscriptions = $db->executequery("SELECT s.*, c.category_name FROM tbl_subscription s JOIN tbl_category c ON s.categoryid = c.categoryid ORDER BY s.categoryid");
?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">Enjoy Our<br>Delicious Meal</h1>
                            <p class="text-white animated slideInLeft mb-4 pb-2">where every bite finds its way to your doorstep, faster and fresher!</p>
                            <a href="#menu" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Book A Plan</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                                <h5>Food at Doorstep</h5>
                                <p>Fresh, tasty meals delivered straight to your doorstep. No cooking, no waiting—just delicious food anytime.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                                <h5>Quality Food</h5>
                                <p>Fresh, high-quality meals made with the finest ingredients. No shortcuts, no compromises—just delicious food every time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                                <h5>Online Order</h5>
                                <p>Order your favorite meals online and get them delivered fast. No waiting in line, no hassle—just tasty food at your convenience.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                                <h5>24/7 Service</h5>
                                <p>Enjoy your favorite meals anytime with our 24/7 service. Always available, always fresh—food whenever you crave it.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->
<section id="menu">
        <!-- Menu Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                    <h1 class="mb-5">Choose Your Favorite Category</h1>
                </div>
                
                <!-- Category Cards -->
                <div class="row g-4 mb-5" id="categoryCards">
                    <?php
                    // Reset the categories result set
                    mysqli_data_seek($categories, 0);
                    while($category = mysqli_fetch_assoc($categories)) {
                        $categoryClass = '';
                        $categoryIcon = '';
                        $categoryDescription = '';
                        
                        switch(strtolower($category['category_name'])) {
                            case 'veg':
                                $categoryClass = 'success';
                                $categoryIcon = 'fa-leaf';
                                $categoryDescription = 'Fresh and healthy vegetarian meals';
                                break;
                            case 'non veg2':
                                $categoryClass = 'danger';
                                $categoryIcon = 'fa-drumstick-bite';
                                $categoryDescription = 'Delicious non-vegetarian dishes';
                                break;
                            case 'mixed':
                                $categoryClass = 'warning';
                                $categoryIcon = 'fa-utensils';
                                $categoryDescription = 'Best of both veg and non-veg';
                                break;
                            default:
                                $categoryClass = 'primary';
                                $categoryIcon = 'fa-utensils';
                                $categoryDescription = 'Delicious meal options';
                        }
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="category-card h-100 text-center p-4 rounded shadow" 
                             onclick="showSubscriptions(<?php echo $category['categoryid']; ?>, '<?php echo $category['category_name']; ?>')" 
                             style="cursor: pointer; transition: transform 0.3s ease; border: 2px solid #<?php echo $categoryClass == 'success' ? '28a745' : ($categoryClass == 'danger' ? 'dc3545' : 'ffc107'); ?>;"
                             onmouseover="this.style.transform='translateY(-10px)'" 
                             onmouseout="this.style.transform='translateY(0)'">
                            <div class="mb-3">
                                <i class="fas <?php echo $categoryIcon; ?> fa-4x text-<?php echo $categoryClass; ?>"></i>
                            </div>
                            <h4 class="mb-3"><?php echo ucfirst($category['category_name']); ?></h4>
                            <p class="text-muted"><?php echo $categoryDescription; ?></p>
                            <div class="mt-3">
                                <span class="btn btn-<?php echo $categoryClass; ?> btn-sm">View Subscriptions</span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
</section>                
                <!-- Subscriptions Display Area -->
                <div id="subscriptionsArea" class="wow fadeInUp" data-wow-delay="0.3s" style="display: none;">
                    <div class="text-center mb-4">
                        <h3 id="selectedCategoryTitle">Available Subscription Plans</h3>
                        <button class="btn btn-secondary btn-sm" onclick="showCategories()">← Back to Categories</button>
                    </div>
                    <div class="row g-4" id="subscriptionsList">
                        <!-- Subscriptions will be loaded here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Custom CSS for category cards -->
        <style>
        .category-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 15px !important;
        }
        .category-card:hover {
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        .subscription-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }
        .subscription-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        </style>
        
        <!-- JavaScript for dynamic content loading -->
        <script>
        // Store all subscriptions data
        const subscriptionsData = [
            <?php
            // Reset subscriptions result set and create JavaScript array
            mysqli_data_seek($subscriptions, 0);
            $subscriptionsArray = [];
            while($sub = mysqli_fetch_assoc($subscriptions)) {
                $subscriptionsArray[] = json_encode($sub);
            }
            echo implode(',', $subscriptionsArray);
            ?>
        ];
        
        function showSubscriptions(categoryId, categoryName) {
            // Hide category cards
            document.getElementById('categoryCards').style.display = 'none';
            
            // Show subscriptions area
            document.getElementById('subscriptionsArea').style.display = 'block';
            
            // Update title
            document.getElementById('selectedCategoryTitle').innerHTML = categoryName.charAt(0).toUpperCase() + categoryName.slice(1) + ' Subscription Plans';
            
            // Filter and display subscriptions for selected category
            const categorySubscriptions = subscriptionsData.filter(sub => sub.categoryid == categoryId);
            
            let subscriptionsHtml = '';
            
            if (categorySubscriptions.length === 0) {
                subscriptionsHtml = '<div class="col-12 text-center"><p class="text-muted">No subscription plans available for this category yet.</p></div>';
            } else {
                categorySubscriptions.forEach(sub => {
                    subscriptionsHtml += `
                        <div class="col-lg-4 col-md-6">
                            <div class="subscription-card h-100 p-4 text-center">
                                <div class="mb-3">
                                    <img src="../uploads/${sub.image}" alt="${sub.subname}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" onerror="this.src='img/menu-1.jpg'">
                                </div>
                                <h5 class="mb-3">${sub.subname}</h5>
                                <div class="mb-3">
                                    <span class="badge bg-primary">${sub.day} Days</span>
                                </div>
                                <h4 class="text-primary mb-3">₹${sub.amount}</h4>
                                <p class="text-muted small mb-4">${sub.description}</p>
                                <button class="btn btn-primary btn-sm" onclick="readMore(${sub.subscriptionid})">Read More</button>
                            </div>
                        </div>
                    `;
                });
            }
            
            document.getElementById('subscriptionsList').innerHTML = subscriptionsHtml;
        }
        
        function showCategories() {
            // Show category cards
            document.getElementById('categoryCards').style.display = 'flex';
            
            // Hide subscriptions area
            document.getElementById('subscriptionsArea').style.display = 'none';
        }
        
        function readMore(subscriptionId) {
            // Redirect to menu.php with subscription plan ID
            window.location.href = 'menu.php?plan=' + subscriptionId;
        }
        </script>
        <!-- Menu End -->


        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">About Us</h5>
                        <h1 class="mb-4">Welcome to <i class="fa fa-utensils text-primary me-2"></i>BiteBox</h1>
                        <p class="mb-4">BiteBox is all about making healthy eating simple and stress-free. We know how busy life can get, and finding the time to plan, cook, and eat right isn’t always easy. That’s why we bring you a variety of ready-made food plans designed to fit different lifestyles and preferences.
</p>
                        <p class="mb-4">With BiteBox, eating well becomes effortless. No more worrying about cooking or skipping meals. Just pick a plan and enjoy food that’s fresh, convenient, and tailored to your needs — straight to your doorstep.
</p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15</h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Years of</p>
                                        <h6 class="text-uppercase mb-0">Experience</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50</h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Popular</p>
                                        <h6 class="text-uppercase mb-0">Master Chefs</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary py-3 px-5 mt-2" href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Testimonial Start -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="text-center">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Testimonial</h5>
                    <h1 class="mb-5">Our Clients Say!!!</h1>
                </div>
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item bg-transparent border rounded p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p>BiteBox has completely changed my meal routine! Fresh, tasty, and delivered right on time — it feels like home-cooked food every single day.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-1.jpg" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Anagha </h5>
                                <small>Food Blogger</small>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-transparent border rounded p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p>The subscription plans are super convenient and budget-friendly. I love how I can customize my meals and never worry about cooking!</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-2.jpg" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Ashiqe</h5>
                                <small>Software Engineer</small>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-transparent border rounded p-4">
                        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                        <p>Great variety, excellent quality, and reliable delivery. BiteBox makes healthy eating so easy — I recommend it to everyone!</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-4.jpg" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h5 class="mb-1">Anjana</h5>
                                <small>Professional Chef</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->
        

 <?php include 'footer.php'; ?>