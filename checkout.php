<?php
session_start();

include 'includes/header.php';
include 'includes/db.php';

// Fetch user cart items
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.*, p.title, p.price FROM cart c JOIN properties p ON c.property_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$grandTotal = 0;
?>

<main>
    <div class="wrapper">
    <!-- Order Summary Section -->
    <section class="order-summary">
        <h1>Order Summary</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $quantity = intval($item['quantity']);
                $price = floatval($item['price']);
                $itemTotal = $price * $quantity;
                $grandTotal += $itemTotal; // Accumulate grand total
                ?>
                <div class="order-item">
                    <div>
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p>Quantity: <?php echo $quantity; ?></p>
                        <p>Price: $<?php echo number_format($price, 2); ?></p>
                        <p>Total: $<?php echo number_format($itemTotal, 2); ?></p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No items in the cart.</p>";
        }
        ?>
        <h3>Grand Total: $<?php echo number_format($grandTotal, 2); ?></h3>
    </section>

    <!-- Billing Details Section -->
    <section class="billing-details">
        <h2>Billing Details</h2>
        <form id="checkoutForm" action="process_checkout.php" method="POST">
            <input type="text" name="billing_name" placeholder="Full Name" required>
            <input type="email" name="billing_email" placeholder="Email Address" required>
            <input type="tel" name="billing_phone" placeholder="Phone Number" required>
            <input type="text" name="billing_address" placeholder="Street Address" required>
            <input type="text" name="billing_city" placeholder="City" required>
            <input type="text" name="billing_state" placeholder="State" required>
            <input type="text" name="billing_zip" placeholder="ZIP/Postal Code" required>
            <input type="text" name="billing_country" placeholder="Country" required>
            <input type="hidden" name="grand_total" value="<?php echo $grandTotal; ?>">

            <!-- Shipping Details Section -->
             <div class="ship-div">
            <section class="shipping-details">
                <h2>Shipping Details</h2>
                <label>
                    <input type="checkbox" id="sameAsBilling" onclick="copyBillingDetails()"> Same as Billing
                </label>
                <input type="text" name="shipping_name" placeholder="Recipient's Name" required>
                <input type="text" name="shipping_address" placeholder="Street Address" required>
                <input type="text" name="shipping_city" placeholder="City" required>
                <input type="text" name="shipping_state" placeholder="State" required>
                <input type="text" name="shipping_zip" placeholder="ZIP/Postal Code" required>
                <input type="text" name="shipping_country" placeholder="Country" required>
            </section>

            <!-- Shipping Options -->
            <section class="shipping-options">
                <h2>Shipping Options</h2>
                <label>
                    <input type="radio" name="shipping_method" value="standard" checked> Standard - 5-7 business days ($10.00)
                </label>
                <label>
                    <input type="radio" name="shipping_method" value="express"> Express - 1-3 business days ($20.00)
                </label>
            </section>
    </div>
            <!-- Submit Button -->
            <button type="submit" class="btn">Submit Order</button>
        </form>
    </section>
    </div>
</main>

<script>
    function copyBillingDetails() {
        const isChecked = document.getElementById("sameAsBilling").checked;
        if (isChecked) {
            document.getElementsByName("shipping_name")[0].value = document.getElementsByName("billing_name")[0].value;
            document.getElementsByName("shipping_address")[0].value = document.getElementsByName("billing_address")[0].value;
            document.getElementsByName("shipping_city")[0].value = document.getElementsByName("billing_city")[0].value;
            document.getElementsByName("shipping_state")[0].value = document.getElementsByName("billing_state")[0].value;
            document.getElementsByName("shipping_zip")[0].value = document.getElementsByName("billing_zip")[0].value;
            document.getElementsByName("shipping_country")[0].value = document.getElementsByName("billing_country")[0].value;
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
