<?php
session_start();
include 'includes/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the database query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit(); // Exit to avoid further execution
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "User not found.";
    }
}
?>

<?php include 'includes/header.php'; ?>

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
                    <?php if (isset($error_message)): ?>
                        <p style="color: red;"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <p>Don't have an account? <a href="signup.php">Register here</a></p>
                </div>
                <div class="login-img">
                    <img src="images/image2.jpg" alt=" image">
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
