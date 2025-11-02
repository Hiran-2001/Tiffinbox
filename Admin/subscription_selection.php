<?php
include('header.php');
include("../dboperation.php");
$obj = new dboperation();

// Fetch all categories
$categories = $obj->executequery("SELECT * FROM tbl_category ORDER BY categoryid");
?>

<br><br><br>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-2">Subscription Menu Management</h4>
                        <p class="text-muted">Select a subscription to add food items to meal plans</p>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="categoryFilter" class="form-label">Filter by Category:</label>
                        <select class="form-select" id="categoryFilter" onchange="filterByCategory()">
                            <option value="">All Categories</option>
                            <?php 
                            mysqli_data_seek($categories, 0);
                            while($category = mysqli_fetch_assoc($categories)) { 
                            ?>
                                <option value="<?php echo $category['categoryid']; ?>">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Subscriptions Grid -->
                <div class="row" id="subscriptionsContainer">
                    <?php
                    // Fetch all subscriptions with category info
                    $subscriptionsQuery = "SELECT s.*, c.category_name 
                                          FROM tbl_subscription s 
                                          JOIN tbl_category c ON s.categoryid = c.categoryid 
                                          ORDER BY s.categoryid, s.subname";
                    $subscriptions = $obj->executequery($subscriptionsQuery);

                    while($subscription = mysqli_fetch_assoc($subscriptions)) {
                        // Get meal plan count for this subscription
                        $mealCountQuery = "SELECT COUNT(*) as meal_count FROM tbl_mealplandetails WHERE subscriptionid = ".$subscription['subscriptionid'];
                        $mealCountResult = $obj->executequery($mealCountQuery);
                        $mealCount = mysqli_fetch_assoc($mealCountResult)['meal_count'];
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4 subscription-card" data-category="<?php echo $subscription['categoryid']; ?>">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><?php echo htmlspecialchars($subscription['subname']); ?></h5>
                                    <span class="badge bg-light text-dark"><?php echo $subscription['category_name']; ?></span>
                                </div>
                            </div>
                            
                            <?php if(!empty($subscription['image'])) { ?>
                            <img src="../uploads/<?php echo htmlspecialchars($subscription['image']); ?>" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;" 
                                 alt="<?php echo htmlspecialchars($subscription['subname']); ?>"
                                 onerror="this.style.display='none';">
                            <?php } ?>
                            
                            <div class="card-body">
                                <p class="card-text"><?php echo htmlspecialchars($subscription['description']); ?></p>
                                
                                <div class="row text-center mb-3">
                                    <div class="col-4">
                                        <div class="border rounded p-2">
                                            <strong><?php echo $subscription['day']; ?></strong>
                                            <br><small class="text-muted">Days</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border rounded p-2">
                                            <strong>₹<?php echo $subscription['amount']; ?></strong>
                                            <br><small class="text-muted">Amount</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border rounded p-2">
                                            <strong><?php echo $mealCount; ?></strong>
                                            <br><small class="text-muted">Meals</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-light">
                                <div class="d-grid gap-2">
                                    <a href="food_add_sub.php?subscriptionid=<?php echo $subscription['subscriptionid']; ?>" 
                                       class="btn btn-success">
                                        <i class="fa fa-plus me-2"></i>Add Food Items
                                    </a>
                                    <div class="btn-group">
                                        <a href="subscriptionedit.php?subscriptionid=<?php echo $subscription['subscriptionid']; ?>" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-info btn-sm" 
                                                onclick="viewDetails(<?php echo $subscription['subscriptionid']; ?>)">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                        <a href="subscriptiondelete.php?did=<?php echo $subscription['subscriptionid']; ?>" 
                                           class="btn btn-outline-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this subscription?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- No subscriptions message -->
                <div id="noSubscriptions" class="text-center py-5" style="display: none;">
                    <i class="fa fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Subscriptions Found</h4>
                    <p class="text-muted">No subscriptions available for the selected category.</p>
                    <a href="subscription.php" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Add New Subscription
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Subscription Details Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subscription Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.subscription-card {
    transition: transform 0.2s ease;
}
.subscription-card:hover {
    transform: translateY(-5px);
}
.card {
    border-radius: 10px;
    overflow: hidden;
}
.card-header {
    border-bottom: none;
}
.btn-group .btn {
    flex: 1;
}
</style>

<script>
function filterByCategory() {
    const categoryFilter = document.getElementById('categoryFilter').value;
    const subscriptionCards = document.querySelectorAll('.subscription-card');
    const noSubscriptionsMsg = document.getElementById('noSubscriptions');
    let visibleCount = 0;

    subscriptionCards.forEach(card => {
        if (categoryFilter === '' || card.dataset.category === categoryFilter) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no subscriptions message
    if (visibleCount === 0) {
        noSubscriptionsMsg.style.display = 'block';
    } else {
        noSubscriptionsMsg.style.display = 'none';
    }
}

function viewDetails(subscriptionId) {
    // Load subscription details via AJAX
    fetch('get_subscription_details.php?id=' + subscriptionId)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('subscriptionModal')).show();
        })
        .catch(error => {
            document.getElementById('modalContent').innerHTML = 
                '<div class="alert alert-danger">Error loading subscription details.</div>';
            new bootstrap.Modal(document.getElementById('subscriptionModal')).show();
        });
}

// Add some animation when cards are loaded
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.subscription-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php include('footer.php'); ?>