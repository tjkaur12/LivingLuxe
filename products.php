<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<section class="full-wid filter">
    <div class="wrapper">
        <div class="filter-inner">
            <h1>Available Properties</h1>
            <form action="products.php" method="get">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort">
                    <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Price (Low to High)</option>
                    <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Price (High to Low)</option>
                </select>
                <button type="submit" class="btn">Sort</button>
            </form>
        </div>
    </div>
</section>

<section class="services full-wid">
    <div class="wrapper">
        <div class="services-inner">
            <div class="heading-section">
                <h2 class="heading">Properties</h2>
                <span class="sub-heading">We'd like to provide you with the following Properties</span>
            </div>
            <div class="ser_items">
                <?php
                // Fetch the selected sort order
                $sort = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc';
                $order = ($sort == 'price_desc') ? 'DESC' : 'ASC';

                // Fetch the properties sorted by price
                $sql = "SELECT * FROM properties ORDER BY price $order";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { 
                        // If image exists in Firebase, construct its URL
                        $imageUrl = '';
                        if ($row['image']) {
                            // Construct the Firebase URL for the image
                            $imageUrl = "https://firebasestorage.googleapis.com/v0/b/fir-groupapp3-f4c61.appspot.com/o/properties_images%2F{$row['image']}?alt=media";
                        }
                ?>
                        <div class="ser_item">
                            <div class="icon">
                                <!-- Display the image from Firebase Storage -->
                                <?php if ($imageUrl): ?>
                                    <img src="<?php echo $imageUrl; ?>" alt="Property Image">
                                <?php else: ?>
                                    <img src="images/default-image.jpg" alt="Default Image"> 
                                <?php endif; ?>
                            </div>
                            <div class="ser_info">
                                <h2><a href="product-detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                                <p>Price: $<?php echo $row['price']; ?></p>
                                <p><?php echo substr($row['description'], 0, 100); ?>...</p>
                            </div>
                        </div>
                <?php  
                    }
                } else { 
                    echo "<p>No properties found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
