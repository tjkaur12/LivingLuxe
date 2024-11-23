<?php include 'includes/db.php';?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listing Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<header class="header">
    <div class="top-bar full-wid">
        <div class="wrapper">
            <div class="top-bar-contact">
                <a href="tel:(123)-456-7890">
                    <i class="fa-solid fa-phone"></i> Phone: +1 (123)-456-7890
                </a>    
                <a href="mailto:info@livingluxe.com">
                    <i class="fa-solid fa-envelope"></i> Email: info@livingluxe.com
                </a>  
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="wrapper">
            <div class="header-inner full-wid">
                <div class="logo">
                    <a class="logo-link" href="index.php">
                        <img src="images/logo.png" width="300" alt="Logo">
                    </a>
                </div>
                <nav class="navigation">
                    <div id="toggle">
                        <i class="fa fa-bars"></i>
                    </div>
                    <ul class="nav-ul">
                        <li class="active">
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="about.php">About Us</a>
                        </li>
                        <li>
                            <a href="products.php">Properties</a>
                        </li>
                        <li>
                            <a href="contact.php">Contact Us</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="signin.php">Sign In</a></li>
                        <?php endif; ?>
                        <li><a href="admin/index.php">Admin</a></li>
                        <li><a href="agent_list.php">Agent List</a></li>
                        <li>
                            <form action="search.php" method="GET" class="search-form">
                                <input type="text" name="keywords" placeholder="Search..." required>
                                <button type="submit" class="search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </li>
                        
                        <li>
                            <a href="cart.php" class="cart-icon">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="item-count">
                                    <?php
                                    // Get the total number of items in the cart
                                    $userId = $_SESSION['user_id'] ?? null; // Use null if user_id is not set
                                    if ($userId) {
                                        $stmt = $conn->prepare("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?");
                                        $stmt->bind_param("i", $userId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        echo $row['total_items'] ? $row['total_items'] : 0; // Display item count
                                    } else {
                                        echo 0; // Display 0 if user is not logged in
                                    }
                                    ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
