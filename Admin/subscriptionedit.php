<?php
include_once('header.php');
include_once('../dboperation.php');
$obj = new dboperation();

// Get subscription ID from URL
$subscriptionId = isset($_GET['subscriptionid']) ? intval($_GET['subscriptionid']) : 0;

if($subscriptionId == 0) {
    echo "<script>alert('Invalid subscription ID'); window.location='subscriptionview.php';</script>";
    exit();
}

// Fetch subscription details
$subscriptionQuery = "SELECT * FROM tbl_subscription WHERE subscriptionid = $subscriptionId";
$subscriptionResult = $obj->executequery($subscriptionQuery);
$subscription = mysqli_fetch_assoc($subscriptionResult);

if(!$subscription) {
    echo "<script>alert('Subscription not found'); window.location='subscriptionview.php';</script>";
    exit();
}

// Fetch categories for dropdown
$categoryQuery = "SELECT * FROM tbl_category ORDER BY category_name";
$categoryResult = $obj->executequery($categoryQuery);
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Edit Subscription</h4>
                    <a href="subscriptionview.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Back to View
                    </a>
                </div>
                
                <form action="subscriptioneditaction.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="subscriptionid" value="<?php echo $subscription['subscriptionid']; ?>">
                    <input type="hidden" name="old_image" value="<?php echo $subscription['image']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sname" class="form-label">Subscription Plan Name <span class="text-danger">*</span></label>
                                <input type="text" name="sname" class="form-control" id="sname" 
                                       value="<?php echo htmlspecialchars($subscription['subname']); ?>" 
                                       required aria-describedby="snameHelp">
                                <div id="snameHelp" class="form-text">Enter a descriptive name for the subscription plan.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoryid" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control" name="categoryid" id="categoryid" required>
                                    <option value="">--------Select Category-----------</option>
                                    <?php
                                    while($category = mysqli_fetch_array($categoryResult)) { 
                                        $selected = ($category['categoryid'] == $subscription['categoryid']) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $category['categoryid']; ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="noday" class="form-label">Number of Days <span class="text-danger">*</span></label>
                                <input type="number" name="noday" class="form-control" id="noday" 
                                       value="<?php echo $subscription['day']; ?>" 
                                       min="1" max="365" required aria-describedby="nodayHelp">
                                <div id="nodayHelp" class="form-text">Duration of the subscription plan in days.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" id="amount" 
                                       value="<?php echo $subscription['amount']; ?>" 
                                       min="0" step="0.01" required aria-describedby="amountHelp">
                                <div id="amountHelp" class="form-text">Total cost for the subscription plan.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="des" class="form-label">Description</label>
                        <textarea name="des" class="form-control" id="des" rows="3" 
                                  aria-describedby="desHelp"><?php echo htmlspecialchars($subscription['description']); ?></textarea>
                        <div id="desHelp" class="form-text">Provide a detailed description of what's included in this subscription.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Subscription Image</label>
                                <input type="file" name="image" class="form-control" id="image" 
                                       accept="image/*" aria-describedby="imageHelp">
                                <div id="imageHelp" class="form-text">Upload a new image if you want to replace the current one. Leave empty to keep the current image.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <?php if(!empty($subscription['image'])) { ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div class="border rounded p-2">
                                        <img src="../uploads/<?php echo htmlspecialchars($subscription['image']); ?>" 
                                             class="img-fluid rounded" 
                                             style="max-height: 150px; object-fit: cover;" 
                                             alt="Current subscription image"
                                             onerror="this.src='../uploads/placeholder.jpg';">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="subscriptionview.php" class="btn btn-secondary">
                                    <i class="fa fa-times me-2"></i>Cancel
                                </a>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fa fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i>Update Subscription
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Preview Card -->
        <div class="col-sm-12 col-xl-4">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-3">Preview</h6>
                <div class="card">
                    <?php if(!empty($subscription['image'])) { ?>
                    <img src="../uploads/<?php echo htmlspecialchars($subscription['image']); ?>" 
                         class="card-img-top" style="height: 200px; object-fit: cover;" 
                         alt="Subscription preview">
                    <?php } ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($subscription['subname']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($subscription['description']); ?></p>
                        <div class="d-flex justify-content-between">
                            <span><strong>Duration:</strong> <?php echo $subscription['day']; ?> days</span>
                            <span><strong>Amount:</strong> ₹<?php echo $subscription['amount']; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6>Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="food_add_sub.php?subscriptionid=<?php echo $subscription['subscriptionid']; ?>" 
                           class="btn btn-success btn-sm">
                            <i class="fa fa-plus me-2"></i>Add Food Items
                        </a>
                        <a href="subscription_selection.php" class="btn btn-info btn-sm">
                            <i class="fa fa-list me-2"></i>Manage All Subscriptions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label .text-danger {
    font-size: 0.8em;
}
.form-text {
    font-size: 0.85em;
}
.card-img-top {
    border-radius: 0.375rem 0.375rem 0 0;
}
</style>

<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    
    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>

<?php include_once('footer.php'); ?>