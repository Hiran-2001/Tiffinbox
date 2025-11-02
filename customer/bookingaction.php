<?php
session_start();
include_once("../dboperation.php");

// Check if user is logged in
if(!isset($_SESSION["username"]) || !isset($_SESSION["customerid"])) {
    echo "<script>alert('Please login to book a subscription.'); window.location='login.php'</script>";
    exit();
}

// Check if form is submitted
if(isset($_POST['book_subscription'])) {
    $obj = new dboperation();
    
    // Get essential booking data
    $customerid = $_SESSION["customerid"];
    $subscriptionid = $_POST["subscriptionid"];
    $startdate = $_POST["startdate"];
    $date = date('Y');
    
    // Get delivery address data
    $delivery_name = $_POST["delivery_name"];
    $delivery_contact = $_POST["delivery_contact"];
    $delivery_location = $_POST["delivery_location"];
    $delivery_houseno = $_POST["delivery_houseno"];
    $delivery_pincode = $_POST["delivery_pincode"];
    $delivery_landmark = $_POST["delivery_landmark"];
    
    // Basic validation
    if(empty($customerid) || empty($subscriptionid) || empty($startdate) || 
       empty($delivery_name) || empty($delivery_contact) || empty($delivery_location) || 
       empty($delivery_houseno) || empty($delivery_pincode) || empty($delivery_landmark)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }
    
    // Validate start date (should not be in the past)
    if(strtotime($startdate) < strtotime(date('Y-m-d'))) {
        echo "<script>alert('Start date cannot be in the past!'); window.history.back();</script>";
        exit();
    }
    
    // Insert booking into tbl_request table
    // Fields: requestid (auto-increment), customerid, subscriptionid, date, startdate, status, delivarypersonid
    $insert_query = "INSERT INTO tbl_request (customerid, subscriptionid, date, startdate, status) 
                    VALUES ('$customerid', '$subscriptionid', '$date', '$startdate', 'pending')";
    
    $result = $obj->executequery($insert_query);
    
    if($result) {
        $requestid = mysqli_insert_id($obj->con);
        
        $delivery_query = "INSERT INTO tbl_deliveryaddress (name, contact, locationid, landmark, houseno, pincode, requestid) 
                          VALUES ('$delivery_name', '$delivery_contact', '$delivery_location', '$delivery_landmark', '$delivery_houseno', '$delivery_pincode', '$requestid')";
        
        $delivery_result = $obj->executequery($delivery_query);
        
        if($delivery_result) {
            echo "<script>
                    alert('Booking successful! Your Order ID is #$requestid. Start Date: $startdate');
                    window.location='orders.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Booking saved but delivery address failed. Please contact support.');
                    window.location='orders.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Booking failed. Please try again.');
                window.history.back();
              </script>";
    }
    
} else {
    // Direct access without form submission
    echo "<script>
            alert('Invalid access!');
            window.location='index.php';
          </script>";
}
?>
