<?php
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 30px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header h2 {
            margin-top: 10px;
            color: #333;
        }

        .profile-header a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .profile-header a:hover {
            background-color: #0056b3;
        }

        .contact-info {
            margin-bottom: 20px;
            font-size: 16px;
            color: #333;
        }

        .bio {
            margin-bottom: 20px;
        }

        .bio h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .bio p {
            font-size: 16px;
            color: #555;
        }

        .social-links {
            margin-bottom: 20px;
        }

        .social-links h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .social-links a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        .navigation-links {
            text-align: center;
            margin-top: 30px;
        }

        .navigation-links a {
            margin: 0 15px;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
        }

        .navigation-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-header">
        <img src="<?php echo htmlspecialchars($agent['profile_picture']); ?>" alt="<?php echo htmlspecialchars($agent['full_name']); ?>">
        <h2><?php echo htmlspecialchars($agent['full_name']); ?></h2>
        <!-- Edit Profile Link -->
        <a href="edit_agent.php?agentId=<?php echo $agent['id']; ?>">Edit Profile</a>
    </div>

    <div class="contact-info">
        <p>Email: <?php echo htmlspecialchars($agent['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($agent['phone']); ?></p>
        <p>Agency: <?php echo htmlspecialchars($agent['agency_name']); ?></p>
    </div>

    <div class="bio">
        <h3>Biography</h3>
        <p><?php echo nl2br(htmlspecialchars($agent['biography'])); ?></p>
    </div>

    <div class="social-links">
        <h3>Follow Me</h3>
        <?php if (!empty($agent['social_media_links'])): ?>
            <?php foreach (explode(',', $agent['social_media_links']) as $link): ?>
                <a href="<?php echo htmlspecialchars(trim($link)); ?>" target="_blank">Social Link</a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="navigation-links">
        <a href="agent_list.php">Back to Agent List</a>
        <a href="index.php">Go to Home</a>
    </div>
</div>

</body>
</html>
