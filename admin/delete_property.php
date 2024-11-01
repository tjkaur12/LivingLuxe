<?php
session_start();
include '../includes/db.php';


// Handle deletion of a property
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $propertyId = intval($_GET['id']);

    // First, delete any related images from the property_images table
    $stmt = $conn->prepare("DELETE FROM property_images WHERE property_id = ?");
    $stmt->bind_param("i", $propertyId);
    $stmt->execute();

    // Then, delete the property from the properties table
    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->bind_param("i", $propertyId);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        header('Location: index.php'); // Redirect back to the properties management page
        exit;
    } else {
        echo "<script>alert('An error occurred while deleting the property.'); window.location.href = 'index.php';</script>";
        exit;
    }
}

// Fetch properties to display in the table
$stmt = $conn->prepare("SELECT * FROM properties ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
