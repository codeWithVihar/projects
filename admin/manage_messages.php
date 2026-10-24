<?php
include 'header.php';
include '../db/db.php';

// Reply to a message
if(isset($_POST['reply'])) {
    $id = intval($_POST['id']);
    $reply = $conn->real_escape_string($_POST['admin_reply']);
    $conn->query("UPDATE contact_messages SET admin_reply='$reply' WHERE id=$id");
    header("Location: manage_messages.php");
    exit;
}

// Fetch messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div class="container py-5">
  <h2 class="mb-4">User Messages</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Admin Reply</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; while($msg = $messages->fetch_assoc()): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo htmlspecialchars($msg['name']); ?></td>
          <td><?php echo htmlspecialchars($msg['email']); ?></td>
          <td><?php echo htmlspecialchars($msg['subject']); ?></td>
          <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
          <td><?php echo nl2br(htmlspecialchars($msg['admin_reply'] ?? '')); ?></td>
          <td>
            <!-- Reply Modal Trigger -->
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $msg['id']; ?>">Reply</button>
          </td>
        </tr>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal<?php echo $msg['id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST">
                <div class="modal-header">
                  <h5 class="modal-title">Reply to <?php echo htmlspecialchars($msg['name']); ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                  <textarea name="admin_reply" class="form-control" rows="4" placeholder="Write your reply..." required><?php echo htmlspecialchars($msg['admin_reply'] ?? ''); ?></textarea>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="reply" class="btn btn-success">Send Reply</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'footer.php'; ?>
