<?php session_start();
include 'config.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

//use session from user_id get
$user_id = $_SESSION['user_id'];

//get id from edit button url 
$edit_id = $_GET['edit_id'];

$sql = $pdo->prepare('SELECT * FROM contacts WHERE id = ? AND user_id = ?');
$sql->execute([$edit_id, $_SESSION['user_id']]);
$contact = $sql->fetch();


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $notes = trim( $_POST['notes']);
    $user_id = $_SESSION['user_id'];

     $sql = $pdo->prepare("UPDATE contacts SET name=?, email=?, phone=?, notes=? WHERE id=? AND user_id=?");
     $sql->execute([$name, $email, $phone, $notes, $edit_id, $user_id]);
     header("Location: dashboard.php");
     exit;
}

?>


<h3>Edit Contact</h3>
<form method="post">
    <input class="form-control mb-2" name="name" value="<?php echo htmlspecialchars($contact['name']) ?>" required>
    <input class="form-control mb-2" name="email" value="<?php echo htmlspecialchars($contact['email']) ?>" required>
    <input class="form-control mb-2" name="phone" value="<?php echo htmlspecialchars($contact['phone']) ?>" required>
    <textarea class="form-control mb-2" name="notes"><?php echo htmlspecialchars($contact['notes']) ?></textarea>
    <button class="btn btn-primary">Update</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'includes/footer.php'; ?>
