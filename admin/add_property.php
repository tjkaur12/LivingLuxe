<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/db.php';
require_once '../vendor/autoload.php'; // Include Firebase SDK

use Kreait\Firebase\Factory;

$message = '';

// Initialize Firebase
$serviceAccountPath = '../fir-groupapp3-f4c61-firebase-adminsdk-9q6y8-93e6534ade.json';
$firebase = (new Factory)
    ->withServiceAccount($serviceAccountPath);

// Get Firebase Storage and other services
$storage = $firebase->createStorage(); // Get Firebase storage bucket
$uploadDir = 'properties_images/';
$bucket = $storage->getBucket(); // Get Firebase storage bucket

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Property details from form
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $size = $_POST['size'];

    // Handle main property image upload to Firebase Storage
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $imageTempPath = $_FILES['image']['tmp_name'];

        // Use file_get_contents() instead of fopen() and fclose()
        $imageContent = file_get_contents($imageTempPath);
        
        if ($imageContent !== false) {
            $imagePath = uniqid() . '-' . $imageName;
            $bucket->upload($imageContent, [
                'name' => $uploadDir . $imagePath
            ]);
        } else {
            $message = "Failed to read image file.";
            die($message);  // Stop the script if file_get_contents fails
        }
    }

    // Insert property details into the database
    $stmt = $conn->prepare("INSERT INTO properties (title, price, description, address, bedrooms, bathrooms, size, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sdssiiis", $title, $price, $description, $address, $bedrooms, $bathrooms, $size, $imagePath);
    
    if ($stmt->execute()) {
        $propertyId = $stmt->insert_id; 

        // Handle gallery image uploads to Firebase Storage
        if (isset($_FILES['gallery_images']) && $_FILES['gallery_images']['error'][0] === UPLOAD_ERR_OK) {
            foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                $galleryImageName = basename($_FILES['gallery_images']['name'][$key]);
                $galleryImageTempPath = $_FILES['gallery_images']['tmp_name'][$key];
                
                // Use file_get_contents() for gallery images as well
                $galleryImageContent = file_get_contents($galleryImageTempPath);
                if ($galleryImageContent !== false) {
                    $galleryImagePath = uniqid() . '-' . $galleryImageName;
                    $bucket->upload($galleryImageContent, [
                        'name' => $uploadDir . $galleryImagePath
                    ]);

                    // Insert gallery image path into the database
                    $stmt = $conn->prepare("INSERT INTO property_images (property_id, image_path) VALUES (?, ?)");
                    $stmt->bind_param("is", $propertyId, $galleryImagePath);
                    $stmt->execute();
                } else {
                    $message = "Failed to read gallery image file.";
                    die($message);  // Stop the script if file_get_contents fails
                }
            }
        }

        $message = "Property added successfully!";
    } else {
        $message = "Error adding property. Please try again.";
    }
}
?>

<?php include 'admin-header.php'; ?>
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
<?php include 'admin-footer.php'; ?>
