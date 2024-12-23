<?php
session_start();

include 'includes/header.php'; 
include 'includes/db.php'; 

// Initialize a message variable
$message = '';

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_quantity') {
    $propertyId = intval($_POST['property_id']);
    $quantity = intval($_POST['quantity']);
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND property_id = ?");
    $stmt->bind_param("iii", $quantity, $userId, $propertyId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Quantity updated successfully.";
    } else {
        echo "Failed to update quantity.";
    }
    exit();
}

// Handle removal of items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $propertyId = intval($_POST['property_id']);
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND property_id = ?");
    $stmt->bind_param("ii", $userId, $propertyId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Item removed successfully.";
    } else {
        $message = "An error occurred while removing the item.";
    }
}
?>

<main>
    <div class="wrapper">
    <div id="cart-items">
        <?php
        if ($message) {
            echo "<p class='message'>$message</p>";
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'] ?? null;

        // Fetch cart items for the user
        $stmt = $conn->prepare("SELECT c.*, p.title, p.price, p.image AS thumbnail_image FROM cart c JOIN properties p ON c.property_id = p.id WHERE c.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $grandTotal = 0; // Initialize grand total
        $cartItems = []; // Initialize an array to hold items for checkout

        while ($item = $result->fetch_assoc()) {
            // Ensure price is correctly formatted
            $price = floatval($item['price']); // Convert to float
            $quantity = intval($item['quantity']); // Convert to integer
            $itemTotal = $price * $quantity; // Calculate item total
            $grandTotal += $itemTotal; // Add to grand total
            
            // Construct the Firebase image URL
            $imageUrl = "https://firebasestorage.googleapis.com/v0/b/fir-groupapp3-f4c61.appspot.com/o/properties_images%2F" . urlencode($item['thumbnail_image']) . "?alt=media";

            echo '<div class="cart-item" id="cart-item-' . $item['property_id'] . '">';
            echo '<div class="cart-item-details">';
            echo '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($item['title']) . '">';
            echo '<h2 class="cart-item-title">' . htmlspecialchars($item['title']) . '</h2>'; // Prevent XSS
            echo '<p class="cart-item-price" data-price="' . $price . '">$' . number_format($price, 2) . '</p>'; // Store price in data attribute
            echo '<div class="quantity-selector">';
            echo '<button class="decrement" onclick="updateQuantity(' . $item['property_id'] . ', -1)">-</button>';
            echo '<span class="quantity">' . $quantity . '</span>';
            echo '<button class="increment" onclick="updateQuantity(' . $item['property_id'] . ', 1)">+</button>';
            echo '</div>';
            echo '<p class="cart-item-total">Total: $' . number_format($itemTotal, 2) . '</p>';
            
            // Form for removing an item
            echo '<form action="cart.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="property_id" value="' . $item['property_id'] . '">';
            echo '<input type="hidden" name="action" value="remove">';
            echo '<button type="button" class="remove-btn" onclick="removeItem(' . $item['property_id'] . ')">Remove</button>';
            echo '</form>';
            
            echo '</div></div>';

            // Add item details to the cartItems array for checkout
            $cartItems[] = [
                'property_id' => $item['property_id'],
                'quantity' => $quantity
            ];
        }
        ?>
    </div>

    <div id="grand-total">
        <h2>Grand Total: $<?php echo number_format($grandTotal, 2); ?></h2>
    </div>

    <form id="checkoutForm" action="checkout.php" method="POST">
    <input type="hidden" name="grand_total" value="<?php echo $grandTotal; ?>">
    
    <!-- Loop through cartItems to create hidden inputs -->
    <?php foreach ($cartItems as $cartItem): ?>
        <input type="hidden" name="items[<?php echo $cartItem['property_id']; ?>][quantity]" value="<?php echo $cartItem['quantity']; ?>">
    <?php endforeach; ?>
    
    <button type="submit" id="checkout-btn">Proceed to Checkout</button>
</form>

    </div>
</main>

<script>
    function updateQuantity(itemId, change) {
        const quantityElement = document.querySelector(`#cart-item-${itemId} .quantity`);
        let currentQuantity = parseInt(quantityElement.innerText);

        if (currentQuantity + change < 1) {
            alert("Minimum quantity is 1");
            return;
        }

        const newQuantity = currentQuantity + change;
        quantityElement.innerText = newQuantity;

        // Fetch the price element and parse the value correctly
        const priceElement = document.querySelector(`#cart-item-${itemId} .cart-item-price`);
        const price = parseFloat(priceElement.getAttribute('data-price'));

        // Update the total price display
        const totalElement = document.querySelector(`#cart-item-${itemId} .cart-item-total`);
        const itemTotal = price * newQuantity;
        totalElement.innerText = 'Total: $' + itemTotal.toFixed(2);

        // Update grand total
        updateGrandTotal();

        // Update the quantity in the database via AJAX
        const formData = new FormData();
        formData.append('property_id', itemId);
        formData.append('quantity', newQuantity);
        formData.append('action', 'update_quantity');

        fetch('cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Quantity updated in the database:', data);
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            alert('An error occurred while updating the quantity.');
        });
    }

    function updateGrandTotal() {
        const cartItems = document.querySelectorAll('.cart-item');
        let grandTotal = 0;

        cartItems.forEach(item => {
            const totalText = item.querySelector('.cart-item-total').innerText;
            const total = parseFloat(totalText.replace('Total: $', '').replace(',', ''));
            grandTotal += total;
        });

        document.getElementById('grand-total').innerHTML = '<h2>Grand Total: $' + grandTotal.toFixed(2) + '</h2>';
    }

    function removeItem(propertyId) {
        const formData = new FormData();
        formData.append('property_id', propertyId);
        formData.append('action', 'remove');

        fetch('cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('cart-item-' + propertyId).remove();
            updateGrandTotal();
        })
        .catch(error => {
            console.error('Error removing item:', error);
            alert('An error occurred while removing the item.');
        });
    }
</script>

<?php include 'includes/footer.php'; ?>
