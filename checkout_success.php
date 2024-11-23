<?php
session_start();
include 'includes/db.php';
require 'vendor/autoload.php';

// Set your secret key (use the test key in your environment)
\Stripe\Stripe::setApiKey('sk_test_51LfHMcSIZHyvezZtVo4f28ccATLElkJdQMUbJ4BmT5cu5gtYubC8CUxHtWxsWEy9FTWRNTG70wN6dJpSYpGCA85b00nalqJT9J');  // Replace with your actual Stripe Secret Key

// Retrieve the session ID from the query string
$sessionId = $_GET['session_id'];

// Retrieve the checkout session details
$session = \Stripe\Checkout\Session::retrieve($sessionId);

// Fetch the user's last order details from the database
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("ii", $session->id, $userId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

?>

<main>
    <div class="wrapper">
        <section class="success">
            <h2>Order Successful!</h2>
            <p>Thank you for your order, <?php echo htmlspecialchars($order['billing_name']); ?>!</p>
            <h3>Order Details:</h3>
            <p>Order ID: <?php echo $order['order_id']; ?></p>
            <p>Total: $<?php echo number_format($order['total'], 2); ?></p>

            <h4>Items:</h4>
            <ul>
                <?php
                // Fetch items for the order
                $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
                $stmt->bind_param("i", $order['order_id']);
                $stmt->execute();
                $items = $stmt->get_result();
                while ($item = $items->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($item['product_name']) . " - " . $item['quantity'] . " x $" . number_format($item['price'], 2) . "</li>";
                }
                ?>
            </ul>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
