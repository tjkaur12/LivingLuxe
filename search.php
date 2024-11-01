<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>


<main>
    <div class="wrapper">
        <h1>Search for Properties</h1>
        <form method="GET" action="search.php" class="search-form">
            <input type="text" name="keywords" placeholder="Search by keywords..." required>
            <input type="text" name="location" placeholder="Enter location..." required>
            <button type="submit" class="btn">Search</button>
        </form>

        <div class="property-list">
        <?php
include 'includes/db.php';

// Check if the form is submitted
if (isset($_GET['keywords']) || isset($_GET['location'])) {
    // Use isset to avoid undefined index warning
    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';
    $location = isset($_GET['location']) ? $_GET['location'] : '';

    // Prepare the SQL query to search properties
    $sql = "SELECT * FROM properties WHERE (title LIKE ? OR description LIKE ?) AND (address LIKE ?)";
    $stmt = $conn->prepare($sql);

    // Add wildcards for the LIKE operator
    $keywords = "%$keywords%";
    $location = "%$location%";

    $stmt->bind_param("sss", $keywords, $keywords, $location);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any properties match the search
    if ($result->num_rows > 0) {
        while ($property = $result->fetch_assoc()) {
            ?>
            <div class="property-item">
                <img src="images/<?php echo $property['image']; ?>" alt="<?php echo $property['title']; ?>">
                <div class="property-info">
                    <h2><?php echo $property['title']; ?></h2>
                    <p><strong>Price:</strong> $<?php echo number_format($property['price'], 2); ?></p>
                    <p><strong>Location:</strong> <?php echo $property['address']; ?></p>
                    <p><strong>Bedrooms:</strong> <?php echo $property['bedrooms']; ?> | <strong>Bathrooms:</strong> <?php echo $property['bathrooms']; ?> | <strong>Size:</strong> <?php echo $property['size']; ?> sq ft</p>
                    <p><?php echo $property['description']; ?></p>
                    <a href="product-detail.php?id=<?php echo $property['id']; ?>" class="btn">View Details</a>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No properties found matching your search criteria.</p>";
    }
    $stmt->close();
}
?>

        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
