<?php 
session_start();
include 'includes/header.php'; 
include 'includes/db.php'; 
?>

<main class="full-wid">
<div class="wrapper">
<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
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
                <h1><?php echo htmlspecialchars($property['title']); ?></h1>
                <p><strong>Price:</strong> $<?php echo number_format($property['price'], 2); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($property['address']); ?></p>
                <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['bedrooms']); ?></p>
                <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['bathrooms']); ?></p>
                <p><strong>Size:</strong> <?php echo htmlspecialchars($property['size']); ?> sq ft</p>
                <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
                
                <!-- Add to Cart Button -->
                <?php if (isset($_SESSION['user_id'])): ?>
    <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
        <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <button type="submit" class="btn">Add to Cart</button>
    </form>
<?php else: ?>
    <p><a href="signin.php">Sign in</a> to add this property to your cart.</p>
<?php endif; ?>

            </div>

            <!-- Image gallery for property images in a slideshow -->
            <div class="property-image-gallery">
                <h2>Photo Gallery</h2>
                <div class="slideshow-container">
                    <?php
                    // Fetch all images associated with the property
                    $imgSql = "SELECT image_path FROM property_images WHERE property_id = ?";
                    $imgStmt = $conn->prepare($imgSql);
                    $imgStmt->bind_param("i", $id);
                    $imgStmt->execute();
                    $imgResult = $imgStmt->get_result();

                    if ($imgResult->num_rows > 0) {
                        while ($img = $imgResult->fetch_assoc()) {
                            // Construct the Firebase URL for the image
                            $imageUrl = "https://firebasestorage.googleapis.com/v0/b/fir-groupapp3-f4c61.appspot.com/o/properties_images%2F" . urlencode($img['image_path']) . "?alt=media";
                            echo "<div class='slide fade'>
                                    <img src='" . $imageUrl . "' alt='Property Image' style='width:100%'>
                                  </div>";
                        }
                    } else {
                        echo "<p>No additional images available.</p>";
                    }
                    $imgStmt->close();
                    ?>
                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
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

<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("slide");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slides[slideIndex - 1].style.display = "block";  
}
</script>

<?php include 'includes/footer.php'; ?>
