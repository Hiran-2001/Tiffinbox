<?php
// accept_delivery.php
session_start();
header('Content-Type: application/json');

require_once '../dboperation.php';   // your DB class
$db = new dboperation();

// ---------- 1. Security ----------
if (!isset($_SESSION['delivery_person_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}
$deliveryPersonId = (int)$_SESSION['delivery_person_id'];   // <-- set this in login!

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$requestId = isset($_POST['requestid']) ? (int)$_POST['requestid'] : 0;
if ($requestId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid request ID']);
    exit;
}

// ---------- 2. Verify the request is still available ----------
$check = $db->executequery(
    "SELECT requestid FROM tbl_request 
     WHERE requestid = ? 
       AND (delivarypersonid IS NULL OR delivarypersonid = 0) 
       AND status = 'Paid'"
);
mysqli_stmt_bind_param($check, "i", $requestId);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) === 0) {
    mysqli_stmt_close($check);
    echo json_encode(['success' => false, 'message' => 'Request no longer available']);
    exit;
}
mysqli_stmt_close($check);

// ---------- 3. Assign the request ----------
$stmt = $db->executequery(
    "UPDATE tbl_request 
     SET delivarypersonid = ?, status = 'Assigned' 
     WHERE requestid = ?"
);
mysqli_stmt_bind_param($stmt, "ii", $deliveryPersonId, $requestId);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($ok) {
    echo json_encode(['success' => true, 'message' => "Delivery #{$requestId} accepted!"]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>