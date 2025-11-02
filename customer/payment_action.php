<?php
session_start();
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["customerid"])) {
    echo "<script>alert('Please login to make payment.'); window.location='login.php'</script>";
    exit();
}

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new dboperation();
    
    // Get form data
    $requestid = $_POST['requestid'];
    $amount = $_POST['amount'];
    $customerid = $_POST['customerid'];
    $payment_method = $_POST['payment_method'];
    
    // Validate session customer ID matches form customer ID
    if($customerid != $_SESSION["customerid"]) {
        echo "<script>alert('Unauthorized access.'); window.location='orders.php'</script>";
        exit();
    }
    
    // Verify the order exists and is accepted
    $verify_query = "SELECT requestid, status FROM tbl_request WHERE requestid = '$requestid' AND customerid = '$customerid' AND status = 'Accepted'";
    $verify_result = $obj->executequery($verify_query);
    
    if(mysqli_num_rows($verify_result) == 0) {
        echo "<script>alert('Order not found or not yet accepted by admin.'); window.location='orders.php'</script>";
        exit();
    }
    
    // Get current date for payment
    $payment_date = date('Y-m-d');
    
    // Insert payment record into tbl_payment
    $payment_query = "INSERT INTO tbl_payment (paymentdate, amount, requestid, status, customerid) 
                      VALUES ('$payment_date', '$amount', '$requestid', 'Paid', '$customerid')";
    
    $payment_result = $obj->executequery($payment_query);
    
    if($payment_result) {
        // Update request status to 'Paid'
        $update_request = "UPDATE tbl_request SET status = 'Paid' WHERE requestid = '$requestid'";
        $update_result = $obj->executequery($update_request);
        
        if($update_result) {
            echo "<script>
                alert('Payment successful! Your order has been confirmed.');
                window.location='orders.php';
            </script>";
        } else {
            echo "<script>
                alert('Payment recorded but failed to update order status. Please contact support.');
                window.location='orders.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Payment failed. Please try again.');
            window.history.back();
        </script>";
    }
    
} else {
    echo "<script>alert('Invalid request.'); window.location='orders.php';</script>";
}
?>