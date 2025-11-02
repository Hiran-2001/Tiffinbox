<?php
session_start();

// Destroy all session variables
session_destroy();

// Redirect to login page with a success message
echo "<script>alert('You have been logged out successfully!'); window.location='../Guest/login.php'</script>";
?>