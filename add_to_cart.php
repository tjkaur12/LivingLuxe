<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if property_id and user_id are set
    if (isset($_POST['property_id']) && isset($_POST['user_id'])) {
        $property_id = intval($_POST['property_id']);
        $user_id = intval($_POST['user_id']);

        // Prepare an SQL statement to insert the item into the cart
        $sql = "INSERT INTO cart (user_id, property_id, quantity) VALUES (?, ?, 1) 
                ON DUPLICATE KEY UPDATE quantity = quantity + 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $property_id);

        if ($stmt->execute()) {
           
            header('Location: products.php'); 
            exit(); 
        } else {
            echo "<p>Error adding to cart. Please try again.</p>";
        }
    } else {
        echo "<p>Invalid request.</p>"; 
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>
