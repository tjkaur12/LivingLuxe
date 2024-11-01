<?php
session_start();


include 'includes/db.php';

if (!isset($_GET['agentId'])) {
    header('Location: agent_list.php');
    exit;
}

$agentId = intval($_GET['agentId']);

// Fetch agent details
$stmt = $conn->prepare("SELECT * FROM agents WHERE id = ?");
$stmt->bind_param("i", $agentId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: agent_list.php');
    exit;
}

$agent = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($agent['full_name']); ?>'s Profile</title>
    <link rel="stylesheet" href="css/agent_styles.css">
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?php echo htmlspecialchars($agent['profile_picture']); ?>" alt="<?php echo htmlspecialchars($agent['full_name']); ?>">
            <h2><?php echo htmlspecialchars($agent['full_name']); ?></h2>
        </div>
        <div class="contact-info">
            <p>Email: <?php echo htmlspecialchars($agent['email']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($agent['phone']); ?></p>
            <p>Agency: <?php echo htmlspecialchars($agent['agency_name']); ?></p>
        </div>
        <div class="bio">
            <h3>Biography</h3>
            <p><?php echo htmlspecialchars($agent['biography']); ?></p>
        </div>
        <div class="social-links">
            <h3>Follow Me</h3>
            <?php if (!empty($agent['social_media_links'])): ?>
                <?php foreach (explode(',', $agent['social_media_links']) as $link): ?>
                    <a href="<?php echo htmlspecialchars(trim($link)); ?>" target="_blank">Social Link</a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
