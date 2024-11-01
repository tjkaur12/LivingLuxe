<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Handle POST requests for updating and removing items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $propertyId = $_POST['property_id'];
    $action = $_POST['action'];

    // Remove item from cart
    if ($action === 'remove') {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND property_id = ?");
        $stmt->bind_param("ii", $userId, $propertyId);
        $stmt->execute();

        // Check if the item was removed successfully
        if ($stmt->affected_rows > 0) {
            // Redirect back to cart page to refresh items
            header('Location: cart.php');
            exit; // Ensure we exit after handling the request
        } else {
            // Handle the error case
            echo "<script>alert('Error removing item from cart. Please try again.'); window.location.href = 'cart.php';</script>";
            exit;
        }
    }
}

// Fetch cart items for the logged-in user
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.*, p.title, p.price, p.image AS thumbnail_image FROM cart c JOIN properties p ON c.property_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$grandTotal = 0; // Initialize grand total
?>
