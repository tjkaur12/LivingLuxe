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

// Update the profile if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and update agent details, excluding social media links
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $agency_name = htmlspecialchars($_POST['agency_name']);
    $biography = htmlspecialchars($_POST['biography']);
    
    // Update agent details in the database (without social media links)
    $updateStmt = $conn->prepare("UPDATE agents SET full_name = ?, email = ?, phone = ?, agency_name = ?, biography = ? WHERE id = ?");
    $updateStmt->bind_param("sssssi", $full_name, $email, $phone, $agency_name, $biography, $agentId);
    
    if ($updateStmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $message = "There was an error updating your profile.";
    }
    
    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            font-size: 18px;
            margin: 10px 0;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Your Profile</h2>
        
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($agent['full_name']); ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($agent['email']); ?>" required>
            
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($agent['phone']); ?>" required>
            
            <label for="agency_name">Agency Name</label>
            <input type="text" id="agency_name" name="agency_name" value="<?php echo htmlspecialchars($agent['agency_name']); ?>" required>
            
            <label for="biography">Biography</label>
            <textarea id="biography" name="biography" rows="4" required><?php echo htmlspecialchars($agent['biography']); ?></textarea>
            
            <button type="submit">Update Profile</button>
        </form>

        <!-- Navigation Links -->
        <div class="links">
            <a href="agent_list.php">Back to Agent List</a>
            <a href="index.php">Go to Home</a>
        </div>
    </div>
</body>
</html>
