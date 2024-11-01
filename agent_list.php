<?php
session_start();
include 'includes/db.php';

// Fetch all agents
$stmt = $conn->prepare("SELECT * FROM agents");
$stmt->execute();
$result = $stmt->get_result();

// Initialize the $agents variable
$agents = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent List</title>
    <link rel="stylesheet" href="css/agent_styles.css">
</head>
<body>
    <div class="container">
        <h1>Agents</h1>
        <ul class="agent-list">
            <?php if (!empty($agents)): ?>
                <?php foreach ($agents as $agent): ?>
                    <li class="agent-list-item">
                        <img src="<?php echo htmlspecialchars($agent['profile_picture']); ?>" alt="<?php echo htmlspecialchars($agent['full_name']); ?>">
                        <h3><a href="view_agent.php?agentId=<?php echo $agent['id']; ?>"><?php echo htmlspecialchars($agent['full_name']); ?></a></h3> <!-- Changed 'id' to 'agentId' -->
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No agents found.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>