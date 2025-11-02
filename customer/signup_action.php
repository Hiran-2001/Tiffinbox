<?php
session_start();
include_once("../dboperation.php");

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new dboperation();
    
    // Get form data
    $customername = $_POST['customername'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $housename = $_POST['housename'];
    $landmark = $_POST['landmark'];
    $pincode = $_POST['pincode'];
    $locationid = $_POST['locationid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate required fields
    if(empty($customername) || empty($email) || empty($contactno) || empty($housename) || 
       empty($landmark) || empty($pincode) || empty($locationid) || empty($username) || empty($password)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit();
    }
    
    // Validate email format
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.'); window.history.back();</script>";
        exit();
    }
    
    // Validate password confirmation
    if($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }
    
    // Check if username already exists
    $check_username = "SELECT customerid FROM tbl_customer WHERE username = '$username'";
    $username_result = $obj->executequery($check_username);
    if(mysqli_num_rows($username_result) > 0) {
        echo "<script>alert('Username already exists. Please choose another username.'); window.history.back();</script>";
        exit();
    }
    
    // Check if email already exists
    $check_email = "SELECT customerid FROM tbl_customer WHERE email = '$email'";
    $email_result = $obj->executequery($check_email);
    if(mysqli_num_rows($email_result) > 0) {
        echo "<script>alert('Email already registered. Please use another email or login.'); window.history.back();</script>";
        exit();
    }
    
    // Insert new customer
    $insert_query = "INSERT INTO tbl_customer (customername, locationid, contactno, email, username, password, housename, pincode, landmark) 
                     VALUES ('$customername', '$locationid', '$contactno', '$email', '$username', '$password', '$housename', '$pincode', '$landmark')";
    
    $result = $obj->executequery($insert_query);
    
    if ($result) {
    // Send registration email
    $mailtoaddress = $email;
    $customername = htmlspecialchars($customername);
    $username = htmlspecialchars($username);
    $email = htmlspecialchars($email);

    // ✅ HTML Email Template
    $bodyContent = '
    <html>
    <head>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f9f9f9;
          margin: 0;
          padding: 0;
        }
        .email-container {
          max-width: 600px;
          background-color: #ffffff;
          margin: 40px auto;
          border-radius: 10px;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
          overflow: hidden;
        }
        .header {
          background-color: #ff7043;
          color: #fff;
          padding: 20px;
          text-align: center;
        }
        .header h1 {
          margin: 0;
          font-size: 24px;
        }
        .content {
          padding: 30px;
          color: #333;
        }
        .content h2 {
          color: #ff7043;
          margin-bottom: 10px;
        }
        .content p {
          line-height: 1.6;
          margin: 10px 0;
        }
        .details {
          background: #fff3e0;
          padding: 15px;
          border-radius: 8px;
          margin-top: 20px;
        }
        .footer {
          background-color: #fafafa;
          color: #777;
          text-align: center;
          padding: 15px;
          font-size: 14px;
        }
        .btn {
          display: inline-block;
          margin-top: 20px;
          padding: 10px 20px;
          background-color: #ff7043;
          color: #fff;
          text-decoration: none;
          border-radius: 5px;
        }
        .btn:hover {
          background-color: #e85c2b;
        }
      </style>
    </head>
    <body>
      <div class="email-container">
        <div class="header">
          <h1>🍱 Welcome to BiteBox!</h1>
        </div>
        <div class="content">
          <h2>Hello, ' . $customername . '!</h2>
          <p>We’re thrilled to have you join our BiteBox family. Your account has been successfully created, and you’re now ready to enjoy delicious, freshly prepared meals delivered straight to your doorstep.</p>

          <div class="details">
            <strong>Account Details:</strong><br>
            Username: ' . $username . '<br>
            Email: ' . $email . '
          </div>

          <p>You can now log in to your account and start ordering your favorite tiffins right away.</p>

          <a href="http://localhost/tiffinbox/customer/login.php" class="btn">Login to BiteBox</a>

          
          <strong>The BiteBox Team</strong></p>
        </div>
        <div class="footer">
          © ' . date("Y") . ' BiteBox | Fresh Meals, Delivered Daily
        </div>
      </div>
    </body>
    </html>
    ';

    include 'phpmailer.php';
} else {
    echo "<script>alert('Failed to create account. Please try again.'); window.history.back();</script>";
}
    
} else {
    echo "<script>alert('Invalid request.'); window.location='signup.php';</script>";
}
?>