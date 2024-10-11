<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>


<section class="full-wid filter">
    <div class="wrapper">
        <div class="filter-inner">
            <h1>Available Properties</h1>
            <form action="products.php" method="get">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort">
                    <option value="price_asc">Price (Low to High)</option>
                    <option value="price_desc">Price (High to Low)</option>
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
                $sort = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc';
                $order = ($sort == 'price_desc') ? 'DESC' : 'ASC';

                $sql = "SELECT * FROM properties ORDER BY price $order";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="ser_item">
                            <div class="icon">
                                <img src="images/<?php echo $row['image']; ?>" alt="Property Image">
                            </div>
                            <div class="ser_info">
                                <h2><a href="product-detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                                <p>Price: $<?php echo $row['price']; ?></p>
                                <p><?php echo substr($row['description'], 0, 100); ?>...</p>
                            </div>
                        </div>
                <?php  
                    } // End of while loop
                } else { 
                    // If no properties found, show message
                    echo "<p>No properties found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
