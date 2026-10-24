<?php
session_start();
include '../db.php';
include 'admin_header.php';

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch all contact messages
$messages = mysqli_query($conn, "SELECT * FROM contacts ORDER BY created_at DESC");
?>

<div class="container py-5">
    <h1 class="text-center text-3xl font-bold text-gray-800 mb-4">
        📩 Contact Messages
    </h1>

    <?php if (mysqli_num_rows($messages) == 0): ?>
        <div class="alert alert-info text-center shadow-sm rounded-2xl">
            No messages found.
        </div>
    <?php else: ?>
        <div class="table-responsive shadow-lg rounded-2xl overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Received On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $i = 1; while ($row = mysqli_fetch_assoc($messages)): ?>
                    <tr>
                        <td class="fw-semibold"><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="text-start"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="delete_message.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-sm btn-danger px-3"
                               onclick="return confirm('Are you sure you want to delete this message?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>
