<?php
include 'includes/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture data and sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $website = htmlspecialchars(trim($_POST['website']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Server-side validation
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($message)) $errors[] = "Message is required";

    // If no errors, store in database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contact_form_submissions (name, email, phone, website, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $website, $message);
        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
    $conn->close();
}
?>
