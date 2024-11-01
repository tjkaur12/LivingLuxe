<?php
session_start();

include 'includes/db.php';

header('Content-Type: application/json'); // Set response content type to JSON

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['total_items' => 0]); // Return 0 if not logged in
    exit;
}

// Fetch the total number of items in the cart
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total_items = $row['total_items'] ? $row['total_items'] : 0; // Default to 0 if no items
echo json_encode(['total_items' => $total_items]);
