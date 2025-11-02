<?php
include("../dboperation.php");
$obj = new dboperation();

if(isset($_POST['submit'])) {
    // Get form data
    $subscriptionId = intval($_POST['subscriptionid']);
    $sname = mysqli_real_escape_string($obj->getConnection(), $_POST['sname']);
    $noday = intval($_POST['noday']);
    $amount = floatval($_POST['amount']);
    $description = mysqli_real_escape_string($obj->getConnection(), $_POST['des']);
    $categoryId = intval($_POST['categoryid']);
    $oldImage = $_POST['old_image'];
    
    // Handle image upload
    $imageName = $oldImage; // Keep old image by default
    
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "../uploads/";
        $fileName = $_FILES['image']['name'];
        $tempName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        
        // Validate file type
        $allowedTypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if(in_array($fileType, $allowedTypes)) {
            // Validate file size (max 5MB)
            if($fileSize <= 5 * 1024 * 1024) {
                // Generate unique filename to avoid conflicts
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $uniqueFileName = 'subscription_' . $subscriptionId . '_' . time() . '.' . $fileExtension;
                
                if(move_uploaded_file($tempName, $uploadDir . $uniqueFileName)) {
                    // Delete old image if it exists and is different
                    if($oldImage && $oldImage != $uniqueFileName && file_exists($uploadDir . $oldImage)) {
                        unlink($uploadDir . $oldImage);
                    }
                    $imageName = $uniqueFileName;
                } else {
                    echo "<script>alert('Error uploading image. Please try again.'); window.history.back();</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Image size should be less than 5MB.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid image type. Please upload JPG, PNG, or GIF files only.'); window.history.back();</script>";
            exit();
        }
    }
    
    // Validate required fields
    if(empty($sname) || $noday <= 0 || $amount < 0 || $categoryId <= 0) {
        echo "<script>alert('Please fill in all required fields with valid values.'); window.history.back();</script>";
        exit();
    }
    
    // Check if subscription name already exists (excluding current subscription)
    $checkQuery = "SELECT * FROM tbl_subscription WHERE subname='$sname' AND subscriptionid != $subscriptionId";
    $checkResult = $obj->executequery($checkQuery);
    
    if(mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('A subscription with this name already exists. Please choose a different name.'); window.history.back();</script>";
        exit();
    }
    
    // Update subscription
    $updateQuery = "UPDATE tbl_subscription SET 
                    subname = '$sname',
                    day = $noday,
                    amount = $amount,
                    description = '$description',
                    categoryid = $categoryId,
                    image = '$imageName'
                    WHERE subscriptionid = $subscriptionId";
    
    $result = $obj->executequery($updateQuery);
    
    if($result) {
        echo "<script>
                alert('Subscription updated successfully!');
                window.location = 'subscriptionview.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating subscription. Please try again.');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request.');
            window.location = 'subscriptionview.php';
          </script>";
}
?>