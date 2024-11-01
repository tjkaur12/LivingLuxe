<?php
session_start();
include '../includes/db.php';

// Initialize message variable
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $size = $_POST['size'];

    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/'; // Directory to store uploaded images
        
        // Check if upload directory exists, if not, create it
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory with proper permissions
        }

        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . uniqid() . '-' . $imageName; // Create a unique file name

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Successfully uploaded
        } else {
            $message = "Failed to upload image.";
        }
    }

    // Prepare and execute the statement to insert a new property
    $stmt = $conn->prepare("INSERT INTO properties (title, price, description, address, bedrooms, bathrooms, size, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sdssiiis", $title, $price, $description, $address, $bedrooms, $bathrooms, $size, $imagePath);
    
    if ($stmt->execute()) {
        $propertyId = $stmt->insert_id; // Get the last inserted property ID

        // Handle gallery image uploads
        if (isset($_FILES['gallery_images']) && $_FILES['gallery_images']['error'][0] === UPLOAD_ERR_OK) {
            foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                $galleryImageName = basename($_FILES['gallery_images']['name'][$key]);
                $galleryImagePath = $uploadDir . uniqid() . '-' . $galleryImageName; // Create a unique file name

                // Move the uploaded gallery image
                if (move_uploaded_file($tmp_name, $galleryImagePath)) {
                    // Insert the gallery image path into the property_images table
                    $stmt = $conn->prepare("INSERT INTO property_images (property_id, image_path) VALUES (?, ?)");
                    $stmt->bind_param("is", $propertyId, $galleryImagePath);
                    $stmt->execute();
                }
            }
        }

        $message = "Property added successfully!";
    } else {
        $message = "Error adding property. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Property</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Add New Property</h1>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="add_property.php" method="POST" enctype="multipart/form-data"> 
        <label for="title">Property Title:</label>
        <input type="text" name="title" required>
        
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required>
        
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        
        <label for="address">Address:</label>
        <input type="text" name="address" required>
        
        <label for="bedrooms">Bedrooms:</label>
        <input type="number" name="bedrooms" required>
        
        <label for="bathrooms">Bathrooms:</label>
        <input type="number" name="bathrooms" required>
        
        <label for="size">Size (sq ft):</label>
        <input type="number" name="size" required>
        
        <label for="image">Property Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <label for="gallery_images">Gallery Images:</label>
        <input type="file" name="gallery_images[]" accept="image/*" multiple>
        
        <button type="submit">Add Property</button>
    </form>
    <a href="index.php">Back to Properties List</a>
</body>
</html>
