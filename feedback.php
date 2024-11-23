<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $success_message = "Thank you for your feedback!";
    } else {
        $error_message = "Failed to submit feedback. Please try again.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<main>
    <section class="inner-page-header full-wid">
        <div class="wrapper">
            <h1>Feedback</h1>
        </div>
    </section>
    
    <main>
    <div class="feedback-page full-wid">
        <div class="wrapper">
            <h1>Feedback Form</h1>
            <p class="f-p">We value your feedback and suggestions to improve our services.</p>

            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="feedback.php" method="post">
                <div class="form-field">
                    <label for="name">Name:</label>
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-field">
                    <label for="message">Message:</label>
                    <textarea name="message" placeholder="Your Feedback" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Submit Feedback</button>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
