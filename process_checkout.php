<?php
session_start();

ob_start();
include 'includes/db.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch data from POST request
$userId = $_SESSION['user_id'];
$billingName = $_POST['billing_name'];
$billingEmail = $_POST['billing_email'];
$billingPhone = $_POST['billing_phone'];
$billingAddress = $_POST['billing_address'];
$billingCity = $_POST['billing_city'];
$billingState = $_POST['billing_state'];
$billingZip = $_POST['billing_zip'];
$billingCountry = $_POST['billing_country'];
$shippingName = $_POST['shipping_name'];
$shippingAddress = $_POST['shipping_address'];
$shippingCity = $_POST['shipping_city'];
$shippingState = $_POST['shipping_state'];
$shippingZip = $_POST['shipping_zip'];
$shippingCountry = $_POST['shipping_country'];
$shippingMethod = $_POST['shipping_method'];


// Calculate total amount from the cart
$stmt = $conn->prepare("SELECT c.quantity, p.price FROM cart c JOIN properties p ON c.property_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$grandTotal = 0;

while ($item = $result->fetch_assoc()) {
    $price = floatval($item['price']);
    $quantity = intval($item['quantity']);
    $grandTotal += $price * $quantity;
}

// Prepare and execute the order insert statement
$stmt = $conn->prepare("INSERT INTO orders (user_id, total, billing_name, billing_email, billing_phone, billing_address, billing_city, billing_state, billing_postal_code, billing_country, shipping_name, shipping_address, shipping_city, shipping_state, shipping_postal_code, shipping_country, shipping_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("idsssssssssssssss", $userId, $grandTotal, $billingName, $billingEmail, $billingPhone, $billingAddress, $billingCity, $billingState, $billingZip, $billingCountry, $shippingName, $shippingAddress, $shippingCity, $shippingState, $shippingZip, $shippingCountry, $shippingMethod);

if ($stmt->execute()) {
    // Clear the cart
    $conn->query("DELETE FROM cart WHERE user_id = $userId");

    // Redirect to success page
    header("Location: checkout_success.php");
    exit(); 
} else {
   
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
ob_end_flush();
?>
