<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <div class="login-outer full-wid">
        <div class="wrapper">
            <div class="login-inner">
                <div class="login-form">
                <h1>Create an Account</h1>
                    <form id="signupForm" action="signup.php" method="post">
                        <div class="form-field">
                            <label for="password">Username:</label>
                            <input type="text" name="username" placeholder="Username" required><br>
                        </div>
                        <div class="form-field">
                            <label for="email">Email:</label>
                            <input type="email" name="email" placeholder="Email" required><br>
                        </div>
                        <div class="form-field">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Password" required><br>
                        </div>
                        
                        <button type="submit" class="btn">Sign Up</button>
                    </form>
                    <p>Already have an account? <a href="signin.php">Login here</a></p>
                </div>
                <div class="login-img">
                    <img src="images/image2.jpg" alt=" image">
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var confirm_password = document.getElementById('confirm_password').value;
        if (password !== confirm_password) {
            event.preventDefault();
            document.getElementById('error').textContent = "Passwords do not match!";
        }
    });
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<p>Passwords do not match.</p>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p>Username or Email already exists.</p>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($stmt->execute()) {
                echo "<p>Registration successful. <a href='signin.php'>Sign In</a></p>";
            } else {
                echo "<p>Registration failed. Please try again.</p>";
            }
        }
    }
}
?>

<?php include 'includes/footer.php'; ?>
