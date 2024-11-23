<?php
session_start();
include '../includes/db.php';

// Initialize a message variable
$message = '';

// Handle deletion of a property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $propertyId = intval($_POST['property_id']);

    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->bind_param("i", $propertyId);
    if ($stmt->execute()) {
        $message = "Property deleted successfully.";
    } else {
        $message = "An error occurred while deleting the property.";
    }
}

// Fetch properties from the database
$stmt = $conn->prepare("SELECT id, title, price, created_at FROM properties");
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'admin-header.php'; ?>
    <div class="wrapper">
        <h1>Properties Management</h1>
        <a href="add_property.php" class="add-property-btn">Add New Property</a>

        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Property Title</th>
                    <th>Price</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($property = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($property['title']); ?></td>
                        <td>$<?php echo number_format($property['price'], 2); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($property['created_at'])); ?></td>
                        <td>
                            <a href="edit_property.php?id=<?php echo $property['id']; ?>">Edit</a>
                            <form action="index.php" method="POST" style="display:inline;">
                                <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this property?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include 'admin-footer.php'; ?>
