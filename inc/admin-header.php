<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset(); 
    session_destroy(); 
    header('Location: admin_login.php'); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Living Luxe - Home</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div class="logo">
        <a href="../views/index.php"><img src="" alt="Living Luxe"></a>
    </div>
    <nav>
        <ul>
            <li><a href="admin_panel.php">Admin</a></li>
            <li><a href="index.php">User Panel</a></li>
            <li><a href="admin_panel.php?logout=true">LogOut</a></li>
        </ul>
    </nav>
</header>
