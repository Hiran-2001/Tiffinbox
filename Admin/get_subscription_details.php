<?php
include("../dboperation.php");
$obj = new dboperation();

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $subscriptionId = intval($_GET['id']);
    
    // Get subscription details
    $subQuery = "SELECT s.*, c.category_name 
                 FROM tbl_subscription s 
                 JOIN tbl_category c ON s.categoryid = c.categoryid 
                 WHERE s.subscriptionid = $subscriptionId";
    $subResult = $obj->executequery($subQuery);
    $subscription = mysqli_fetch_assoc($subResult);
    
    if($subscription) {
        // Get meal plan details
        $mealQuery = "SELECT mpd.*, fi.foodname, mt.typename as mealtype, mpd.daynum
                      FROM tbl_mealplandetails mpd 
                      JOIN tbl_fooditem fi ON mpd.foodid = fi.foodid 
                      JOIN tbl_mealtype mt ON fi.mealtypeid = mt.mealtypeid 
                      WHERE mpd.subscriptionid = $subscriptionId 
                      ORDER BY mpd.daynum, fi.mealtypeid";
        $mealResult = $obj->executequery($mealQuery);
        
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        
        if(!empty($subscription['image'])) {
            echo '<img src="../uploads/'.htmlspecialchars($subscription['image']).'" 
                       class="img-fluid rounded mb-3" 
                       alt="'.htmlspecialchars($subscription['subname']).'">';
        }
        
        echo '<h5>'.htmlspecialchars($subscription['subname']).'</h5>';
        echo '<p><strong>Category:</strong> '.$subscription['category_name'].'</p>';
        echo '<p><strong>Description:</strong> '.htmlspecialchars($subscription['description']).'</p>';
        echo '<p><strong>Duration:</strong> '.$subscription['day'].' days</p>';
        echo '<p><strong>Amount:</strong> ₹'.$subscription['amount'].'</p>';
        
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<h6>Current Meal Plan:</h6>';
        
        if(mysqli_num_rows($mealResult) > 0) {
            $mealsByDay = [];
            
            // Group meals by day and meal type
            while($meal = mysqli_fetch_assoc($mealResult)) {
                $day = $meal['daynum'];
                $mealType = $meal['mealtype'];
                
                if(!isset($mealsByDay[$day])) {
                    $mealsByDay[$day] = [];
                }
                if(!isset($mealsByDay[$day][$mealType])) {
                    $mealsByDay[$day][$mealType] = [];
                }
                $mealsByDay[$day][$mealType][] = $meal['foodname'];
            }
            
            echo '<div class="meal-plan-details">';
            
            // Display meals grouped by day
            ksort($mealsByDay); // Sort by day number
            foreach($mealsByDay as $day => $mealsForDay) {
                echo '<h6 class="mt-3 mb-2 text-success">Day '.$day.'</h6>';
                echo '<div class="card card-body bg-light">';
                
                foreach(['Breakfast', 'Lunch', 'Dinner'] as $mealType) {
                    if(isset($mealsForDay[$mealType])) {
                        echo '<div class="mb-2">';
                        echo '<strong class="text-primary">'.$mealType.':</strong> ';
                        echo implode(', ', $mealsForDay[$mealType]);
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<div class="alert alert-info">No meal items added yet.</div>';
        }
        
        echo '</div>';
        echo '</div>';
        
        echo '<div class="row mt-3">';
        echo '<div class="col-12">';
        echo '<div class="d-flex gap-2 justify-content-center">';
        echo '<a href="food_add_sub.php?subscriptionid='.$subscriptionId.'" class="btn btn-success">';
        echo '<i class="fa fa-plus"></i> Add Food Items</a>';
        echo '<a href="subscriptionedit.php?subscriptionid='.$subscriptionId.'" class="btn btn-primary">';
        echo '<i class="fa fa-edit"></i> Edit Subscription</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
    } else {
        echo '<div class="alert alert-danger">Subscription not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid subscription ID.</div>';
}
?>