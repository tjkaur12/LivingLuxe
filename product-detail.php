<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>
<main class="full-wid">
<div class="wrapper">
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM properties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $property = $result->fetch_assoc();
    ?>
        <div class="property-detail-container">
            <div class="property-info">
                <h1><?php echo $property['title']; ?></h1>
                <p><strong>Price:</strong> $<?php echo $property['price']; ?></p>
                <p><?php echo $property['description']; ?></p>
                <a href="#" class="btn">Apply Now</a>
            </div>
            <div class="property-image">
                <?php echo "<img src='images/" . $property['image'] . "' alt='Property Image'>"; ?>
            </div>
        </div>
    <?php
    } else {
        echo "<p>Property not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
</div>
</main>
<?php include 'includes/footer.php'; ?>