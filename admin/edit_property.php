<?php
session_start();
include '../includes/db.php';

// Initialize message variable
$message = '';

// Check if an ID is provided
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$propertyId = intval($_GET['id']);

// Fetch the existing property details
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $propertyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit; // Property not found
}

$property = $result->fetch_assoc();

// Handle form submission for updating property
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $address = $_POST['address'] ?? '';
    $bedrooms = $_POST['bedrooms'] ?? 0;
    $bathrooms = $_POST['bathrooms'] ?? 0;
    $size = $_POST['size'] ?? 0;

    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE properties SET title = ?, price = ?, description = ?, address = ?, bedrooms = ?, bathrooms = ?, size = ? WHERE id = ?");
    $stmt->bind_param("sdssiisi", $title, $price, $description, $address, $bedrooms, $bathrooms, $size, $propertyId);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        $message = "An error occurred while updating the property.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Property</h1>
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <form action="edit_property.php?id=<?php echo $propertyId; ?>" method="POST">
            <div>
                <label for="title">Property Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
            </div>
            <div>
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($property['price']); ?>" step="0.01" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required><?php echo htmlspecialchars($property['description']); ?></textarea>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($property['address']); ?>" required>
            </div>
            <div>
                <label for="bedrooms">Bedrooms:</label>
                <input type="number" name="bedrooms" id="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required>
            </div>
            <div>
                <label for="bathrooms">Bathrooms:</label>
                <input type="number" name="bathrooms" id="bathrooms" value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required>
            </div>
            <div>
                <label for="size">Size (sq ft):</label>
                <input type="number" name="size" id="size" value="<?php echo htmlspecialchars($property['size']); ?>" required>
            </div>
            <button type="submit">Update Property</button>
        </form>
    </div>
</body>
</html>
