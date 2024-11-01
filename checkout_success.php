<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

// Fetch the last order for the user
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_id DESC LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo "<p>No order found.</p>";
    exit;
}

// Display order details
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
            $stmt = $conn->prepare("SELECT c.quantity, p.title, p.price FROM cart c JOIN properties p ON c.property_id = p.id WHERE c.user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $itemsResult = $stmt->get_result();

            while ($item = $itemsResult->fetch_assoc()) {
                $itemTotal = floatval($item['price']) * intval($item['quantity']);
                echo "<li>" . htmlspecialchars($item['title']) . " - Quantity: " . intval($item['quantity']) . " - Total: $" . number_format($itemTotal, 2) . "</li>";
            }
            ?>
        </ul>

        <p>Your order will be shipped to:</p>
        <p><?php echo htmlspecialchars($order['shipping_name']); ?><br>
           <?php echo htmlspecialchars($order['shipping_address']) . ', ' . htmlspecialchars($order['shipping_city']) . ', ' . htmlspecialchars($order['shipping_state']) . ' ' . htmlspecialchars($order['shipping_postal_code']) . ', ' . htmlspecialchars($order['shipping_country']); ?>
        </p>
    </section>
        </div>
</main>

<?php include 'includes/footer.php'; ?>
