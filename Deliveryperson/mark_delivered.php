<?php
// mark_delivered.php
session_start();
header('Content-Type: application/json');

require_once '../dboperation.php';
$db = new dboperation();

// ---------- 1. Security ----------
if (!isset($_SESSION['deliverypersonid'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}
$deliveryPersonId = (int) $_SESSION['deliverypersonid'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$requestId = isset($_POST['requestid']) ? (int) $_POST['requestid'] : 0;
if ($requestId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid request ID']);
    exit;
}

// ---------- 2. Verify the request is assigned to this delivery person ----------
$check = $db->con->prepare(
    "SELECT requestid FROM tbl_request 
     WHERE requestid = ? 
       AND delivarypersonid = ? 
       AND status IN ('Assigned', 'Paid')"
);

$check->bind_param("ii", $requestId, $deliveryPersonId);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    $check->close();
    echo json_encode(['success' => false, 'message' => 'Request not found or not assigned to you']);
    exit;
}
$check->close();

// ---------- 3. Mark as delivered ----------
$stmt = $db->con->prepare(
    "UPDATE tbl_request 
     SET status = 'Delivered' 
     WHERE requestid = ? AND delivarypersonid = ?"
);

$stmt->bind_param("ii", $requestId, $deliveryPersonId);
$ok = $stmt->execute();
$stmt->close();

echo json_encode([
    'success' => $ok,
    'message' => $ok ? "Delivery #$requestId marked as delivered!" : "Database error"
]);
?>