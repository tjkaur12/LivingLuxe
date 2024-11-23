<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password for the given email
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $success_message = "Password updated successfully. You can now <a href='signin.php'>Sign In</a>.";
    } else {
        $error_message = "No account found with this email or unable to update password.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="reset-password-outer full-wid">
        <div class="wrapper">
            <div class="reset-password-inner">
                <div class="reset-password-form">
                    <h1>Reset Password</h1>
                    <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                    <?php elseif (isset($success_message)): ?>
                        <p style="color: green;"><?php echo $success_message; ?></p>
                    <?php endif; ?>

                    <form action="forgot.php" method="post">
                        <div class="form-field">
                            <label for="email">Email:</label>
                            <input type="email" name="email" placeholder="Enter your registered email" required><br>
                        </div>
                        <div class="form-field">
                            <label for="new_password">New Password:</label>
                            <input type="password" name="new_password" placeholder="Enter new password" required><br>
                        </div>
                        <button type="submit" class="btn">Reset Password</button>
                    </form>
                </div>
                
            <div class="login-img">
                <img src="images/image2.jpg" alt=" image">
            </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
