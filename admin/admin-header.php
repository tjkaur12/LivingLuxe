<?php include 'includes/db.php';?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listing Website</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/style.css">
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
                        <img src="../images/logo.png" width="300" alt="Logo">
                    </a>
                </div>
                <nav class="navigation">
                    <div id="toggle">
                        <i class="fa fa-bars"></i>
                    </div>
                    <ul class="nav-ul">
                        <li class="active">
                            <a href="../index.php">Home</a>
                        </li>
                        <li><a href="index.php">Admin</a></li>
                        <li><a href="admin-feedback.php">Feedback</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
