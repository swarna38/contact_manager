<?php
session_start();
include 'config.php';
include 'includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {
    $query = '%' . trim($_GET['query']) . '%';
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE user_id = ? AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)");
    $stmt->execute([$user_id, $query, $query, $query]);
    $results = $stmt->fetchAll();
}
?>

<h3>Search Contacts</h3>

<form method="get" class="mb-4">
    <input type="text" name="query" class="form-control mb-2" placeholder="Search by name, email or phone" required>
    <button class="btn btn-primary">Search</button>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
</form>

<?php if ($results): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Notes</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                    <td><?= htmlspecialchars($contact['notes']) ?></td>
                    <td>
                        <a href="edit_contact.php?edit_id=<?= $contact['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_contact.php?delete_id=<?= $contact['id'] ?>" onclick="return confirm('Delete this contact?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (isset($_GET['query'])): ?>
    <div class="alert alert-warning">No contacts found for: <strong><?= htmlspecialchars($_GET['query']) ?></strong></div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
