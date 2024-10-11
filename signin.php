<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <div class="login-outer full-wid">
        <div class="wrapper">
            <div class="login-inner">
                <div class="login-form">
                    <h1>Login</h1>
                    
                    <form action="signin.php" method="post">
                        <div class="form-field">
                            <label for="email">Email:</label>
                            <input type="text" name="username" placeholder="Username or Email" required><br>
                        </div>
                        <div class="form-field">
                            <label for="password">Password:</label>
                            <input type="password" name="password" placeholder="Password" required><br>
                        </div>
                        <button type="submit" class="btn">Sign In</button>
                    </form>
                    <p>Don't have an account? <a href="signup.php">Register here</a></p>
                </div>
                <div class="login-img">
                    <img src="images/image2.jpg" alt=" image">
                </div>
            </div>
        </div>
    </div>
</main>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
}
?>

<?php include 'includes/footer.php'; ?>
