<?php
include("header.php");
include_once("../dboperation.php");

$obj = new dboperation();

// Get current date for today's statistics
$today = date('Y-m-d');
$current_month = date('Y-m');

// Total Customers
$total_customers_query = "SELECT COUNT(*) as total_customers FROM tbl_customer";
$total_customers_result = $obj->executequery($total_customers_query);
$total_customers = mysqli_fetch_array($total_customers_result)['total_customers'];

// Total Orders
$total_orders_query = "SELECT COUNT(*) as total_orders FROM tbl_request";
$total_orders_result = $obj->executequery($total_orders_query);
$total_orders = mysqli_fetch_array($total_orders_result)['total_orders'];

// Total Revenue from Paid Orders
$total_revenue_query = "SELECT SUM(p.amount) as total_revenue FROM tbl_payment p WHERE p.status = 'Paid'";
$total_revenue_result = $obj->executequery($total_revenue_query);
$total_revenue = mysqli_fetch_array($total_revenue_result)['total_revenue'] ?? 0;

// Today's Orders
$today_orders_query = "SELECT COUNT(*) as today_orders FROM tbl_request WHERE DATE(startdate) = '$today'";
$today_orders_result = $obj->executequery($today_orders_query);
$today_orders = mysqli_fetch_array($today_orders_result)['today_orders'];

// Today's Revenue
$today_revenue_query = "SELECT SUM(p.amount) as today_revenue FROM tbl_payment p WHERE DATE(p.paymentdate) = '$today' AND p.status = 'Paid'";
$today_revenue_result = $obj->executequery($today_revenue_query);
$today_revenue = mysqli_fetch_array($today_revenue_result)['today_revenue'] ?? 0;

// Pending Orders
$pending_orders_query = "SELECT COUNT(*) as pending_orders FROM tbl_request WHERE status = 'pending'";
$pending_orders_result = $obj->executequery($pending_orders_query);
$pending_orders = mysqli_fetch_array($pending_orders_result)['pending_orders'];

// Food Items Count
$food_items_query = "SELECT COUNT(*) as food_items FROM tbl_fooditem";
$food_items_result = $obj->executequery($food_items_query);
$food_items = mysqli_fetch_array($food_items_result)['food_items'];

// Subscription Plans Count
$subscriptions_query = "SELECT COUNT(*) as subscriptions FROM tbl_subscription";
$subscriptions_result = $obj->executequery($subscriptions_query);
$subscriptions = mysqli_fetch_array($subscriptions_result)['subscriptions'];
?>
 <!-- BiteBox Statistics Start -->
            <div class="container-fluid pt-4 px-4">
                <h4 class="mb-4">BiteBox Dashboard Reports</h4>
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4 text-white">
                            <i class="fa fa-users fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Customers</p>
                                <h6 class="mb-0"><?php echo $total_customers; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-success rounded d-flex align-items-center justify-content-between p-4 text-white">
                            <i class="fa fa-shopping-cart fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Orders</p>
                                <h6 class="mb-0"><?php echo $total_orders; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-info rounded d-flex align-items-center justify-content-between p-4 text-white">
                            <i class="fa fa-rupee-sign fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Revenue</p>
                                <h6 class="mb-0">₹<?php echo number_format($total_revenue); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-warning rounded d-flex align-items-center justify-content-between p-4 text-white">
                            <i class="fa fa-clock fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Pending Orders</p>
                                <h6 class="mb-0"><?php echo $pending_orders; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Second Row Statistics -->
                <div class="row g-4 mt-2">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-calendar-day fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today's Orders</p>
                                <h6 class="mb-0"><?php echo $today_orders; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-money-bill-wave fa-3x text-success"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today's Revenue</p>
                                <h6 class="mb-0">₹<?php echo number_format($today_revenue); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-utensils fa-3x text-info"></i>
                            <div class="ms-3">
                                <p class="mb-2">Food Items</p>
                                <h6 class="mb-0"><?php echo $food_items; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-list-alt fa-3x text-warning"></i>
                            <div class="ms-3">
                                <p class="mb-2">Subscription Plans</p>
                                <h6 class="mb-0"><?php echo $subscriptions; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BiteBox Statistics End -->


            <!-- Order Status & Category Reports Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Order Status Report</h6>
                                <a href="viewrequest.php">View All Orders</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Count</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status_query = "SELECT status, COUNT(*) as count FROM tbl_request GROUP BY status";
                                        $status_result = $obj->executequery($status_query);
                                        while($status_row = mysqli_fetch_array($status_result)) {
                                            $percentage = ($status_row['count'] / $total_orders) * 100;
                                            $badge_class = '';
                                            switch(strtolower($status_row['status'])) {
                                                case 'pending': $badge_class = 'bg-warning'; break;
                                                case 'paid': $badge_class = 'bg-success'; break;
                                                case 'accepted': $badge_class = 'bg-info'; break;
                                                default: $badge_class = 'bg-secondary'; break;
                                            }
                                        ?>
                                        <tr>
                                            <td><span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($status_row['status']); ?></span></td>
                                            <td><?php echo $status_row['count']; ?></td>
                                            <td><?php echo number_format($percentage, 1); ?>%</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Food Category Report</h6>
                                <a href="categoryview.php">Manage Categories</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Food Items</th>
                                            <th>Active Orders</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $category_query = "SELECT c.category_name, 
                                                          COUNT(f.foodid) as food_count,
                                                          COUNT(DISTINCT r.requestid) as order_count
                                                          FROM tbl_category c
                                                          LEFT JOIN tbl_fooditem f ON c.categoryid = f.categoryid
                                                          LEFT JOIN tbl_subscription s ON c.categoryid = s.categoryid
                                                          LEFT JOIN tbl_request r ON s.subscriptionid = r.subscriptionid AND r.status IN ('pending', 'paid', 'accepted')
                                                          GROUP BY c.categoryid, c.category_name";
                                        $category_result = $obj->executequery($category_query);
                                        while($cat_row = mysqli_fetch_array($category_result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo ucfirst($cat_row['category_name']); ?></td>
                                            <td><?php echo $cat_row['food_count']; ?></td>
                                            <td><?php echo $cat_row['order_count']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Status & Category Reports End -->


            <!-- Recent Orders & Payments Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Recent Orders & Payments</h6>
                                <a href="viewrequest.php">Show All Orders</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <thead>
                                        <tr class="text-dark">
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Subscription</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $recent_orders_query = "SELECT r.requestid, r.startdate, r.status,
                                                               c.customername, c.contactno,
                                                               s.subname, s.amount,
                                                               p.status as payment_status, p.paymentdate
                                                               FROM tbl_request r
                                                               LEFT JOIN tbl_customer c ON r.customerid = c.customerid
                                                               LEFT JOIN tbl_subscription s ON r.subscriptionid = s.subscriptionid
                                                               LEFT JOIN tbl_payment p ON r.requestid = p.requestid
                                                               ORDER BY r.requestid DESC
                                                               LIMIT 10";
                                        $recent_result = $obj->executequery($recent_orders_query);
                                        
                                        if(mysqli_num_rows($recent_result) > 0) {
                                            while($order = mysqli_fetch_array($recent_result)) {
                                                $status_badge = '';
                                                switch(strtolower($order['status'])) {
                                                    case 'pending': $status_badge = 'bg-warning text-dark'; break;
                                                    case 'paid': $status_badge = 'bg-success'; break;
                                                    case 'accepted': $status_badge = 'bg-info'; break;
                                                    default: $status_badge = 'bg-secondary'; break;
                                                }
                                                
                                                $payment_badge = '';
                                                $payment_text = 'Not Paid';
                                                if($order['payment_status'] == 'Paid') {
                                                    $payment_badge = 'bg-success';
                                                    $payment_text = 'Paid';
                                                } else {
                                                    $payment_badge = 'bg-danger';
                                                }
                                        ?>
                                        <tr>
                                            <td>#<?php echo $order['requestid']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['startdate'])); ?></td>
                                            <td>
                                                <?php echo $order['customername']; ?><br>
                                                <small class="text-muted"><?php echo $order['contactno']; ?></small>
                                            </td>
                                            <td><?php echo $order['subname']; ?></td>
                                            <td>₹<?php echo number_format($order['amount']); ?></td>
                                            <td><span class="badge <?php echo $status_badge; ?>"><?php echo ucfirst($order['status']); ?></span></td>
                                            <td>
                                                <span class="badge <?php echo $payment_badge; ?>"><?php echo $payment_text; ?></span>
                                                <?php if($order['payment_status'] == 'Paid'): ?>
                                                <br><small class="text-muted"><?php echo date('M d', strtotime($order['paymentdate'])); ?></small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else { 
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No orders found</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Orders & Payments End -->


            <!-- Reports & System Info Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!-- Recent Customers -->
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Recent Customers</h6>
                                <a href="#">View All</a>
                            </div>
                            <?php
                            $recent_customers_query = "SELECT customername, email, contactno FROM tbl_customer ORDER BY customerid DESC LIMIT 5";
                            $recent_customers_result = $obj->executequery($recent_customers_query);
                            while($customer = mysqli_fetch_array($recent_customers_result)) {
                            ?>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fa fa-user text-white"></i>
                                </div>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0"><?php echo $customer['customername']; ?></h6>
                                    </div>
                                    <span class="text-muted small"><?php echo $customer['email']; ?></span><br>
                                    <span class="text-muted small"><?php echo $customer['contactno']; ?></span>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Monthly Revenue Report -->
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Monthly Revenue</h6>
                                <a href="#">View Details</a>
                            </div>
                            <?php
                            $monthly_revenue_query = "SELECT DATE_FORMAT(p.paymentdate, '%Y-%m') as month, 
                                                     SUM(p.amount) as revenue, COUNT(*) as orders
                                                     FROM tbl_payment p 
                                                     WHERE p.status = 'Paid' 
                                                     GROUP BY DATE_FORMAT(p.paymentdate, '%Y-%m')
                                                     ORDER BY month DESC LIMIT 6";
                            $monthly_result = $obj->executequery($monthly_revenue_query);
                            while($month = mysqli_fetch_array($monthly_result)) {
                                $month_name = date('M Y', strtotime($month['month'] . '-01'));
                            ?>
                            <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                                <div>
                                    <h6 class="mb-0"><?php echo $month_name; ?></h6>
                                    <small class="text-muted"><?php echo $month['orders']; ?> orders</small>
                                </div>
                                <span class="text-success fw-bold">₹<?php echo number_format($month['revenue']); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- Quick Actions & System Info -->
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            
                            <div class="d-grid gap-2 mb-4">
                                <a href="fooditem.php" class="btn btn-outline-primary">
                                    <i class="fa fa-plus me-2"></i>Add New Food Item
                                </a>
                                <div class="d-grid gap-2 mb-4">
                                <a href="excel.php" class="btn btn-outline-primary">
                                    <i class="fa fa-plus me-2"></i>view excel report
                                </a>
                                <a href="subscription.php" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>Create Subscription
                                </a>
                                <a href="viewrequest.php" class="btn btn-outline-info">
                                    <i class="fa fa-eye me-2"></i>View Pending Orders
                                </a>
                                <a href="viewassign_delivery.php" class="btn btn-outline-warning">
                                    <i class="fa fa-truck me-2"></i>Assign Deliveries
                                </a>
                            </div>
                            
                            <div class="border-top pt-3">
                                <h6 class="mb-2">System Info</h6>
                                <small class="text-muted d-block">Last Login: <?php echo date('M d, Y H:i'); ?></small>
                                <small class="text-muted d-block">Server: BiteBox Admin</small>
                                <small class="text-muted d-block">Version: 1.0</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Reports & System Info End -->
            <?php
            include_once("footer.php");
            ?>