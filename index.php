<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <section class="welcome full-wid">
        <div class="wrapper">
            <div class="welcome-inner">
                <h1>Discover Your Perfect Property</h1>
                <p>Browse thousands of homes, rentals, and commercial<br> properties tailored to your needs.</p>
                <a href="#" class="btn">Learn More</a>
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
                $sql = "SELECT * FROM properties ORDER BY created_at DESC LIMIT 5";
                $result = $conn->query($sql); 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { 
                ?>
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
                    }
                } else { 
                    echo "No properties found.";
                } 
                ?>
            </div>
        </div>
    </div>
</section>

</main>

<?php include 'includes/footer.php'; ?>
