<?php
session_start();

// Set the content type to JSON
header('Content-Type: application/json');

// Include the database connection and Stripe library
include 'includes/db.php';
require_once 'vendor/autoload.php'; // Ensure you have installed Stripe's PHP SDK

// Check if user is logged in
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['error' => 'User not logged in. Please log in to continue.']);
    exit;
}

// Fetch cart items for the logged-in user
$stmt = $conn->prepare("SELECT c.*, p.title, p.price FROM cart c JOIN properties p ON c.property_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Initialize the total amount to zero
$grandTotal = 0;

// Check if cart has items
if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
        $quantity = intval($item['quantity']);
        $price = floatval($item['price']);
        $itemTotal = $price * $quantity;
        $grandTotal += $itemTotal; // Accumulate grand total
    }
} else {
    echo json_encode(['error' => 'No items in the cart.']);
    exit;
}

// Ensure grand total is positive before proceeding
if ($grandTotal <= 0) {
    echo json_encode(['error' => 'Invalid cart total.']);
    exit;
}

// Get the payment method and billing details from the POST data
$payload = json_decode(file_get_contents('php://input'), true);

if (empty($payload['billing_name']) || empty($payload['billing_email']) || empty($payload['billing_address']) || empty($payload['billing_city']) || empty($payload['billing_state']) || empty($payload['billing_zip']) || empty($payload['billing_country'])) {
    echo json_encode(['error' => 'Missing required billing information.']);
    exit;
}

// Create a Stripe session
try {
    \Stripe\Stripe::setApiKey('sk_test_51LfHMcSIZHyvezZtVo4f28ccATLElkJdQMUbJ4BmT5cu5gtYubC8CUxHtWxsWEy9FTWRNTG70wN6dJpSYpGCA85b00nalqJT9J'); // Replace with your Stripe secret key

    // Create the checkout session
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Cart Total'],
                    'unit_amount' => $grandTotal * 100, // Convert to cents
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => 'https://example.com/success', // Redirect URL for success
        'cancel_url' => 'https://example.com/cancel', // Redirect URL for cancel
    ]);

    // Return the session ID as a JSON response
    echo json_encode(['id' => $session->id]);

} catch (\Stripe\Exception\ApiErrorException $e) {
    // Handle Stripe API errors
    echo json_encode(['error' => 'Stripe API error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle general errors
    echo json_encode(['error' => 'An error occurred while processing the checkout: ' . $e->getMessage()]);
}
?>
