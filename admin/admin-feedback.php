<?php
session_start();
include 'includes/db.php';

// Fetch all feedback from the database
$query = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<?php include 'admin-header.php'; ?>

<main>
    <div class="admin-feedback-page full-wid">
        <div class="wrapper">
            <h1>Feedback List</h1>

            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'admin-footer.php'; ?>
