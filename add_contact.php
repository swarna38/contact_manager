<?php session_start();
include 'config.php';
include 'includes/header.php';

// check if session user_id not set
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
}

//get data form
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];

    $sql = $pdo->prepare("INSERT INTO contacts (user_id, name, email, phone, notes) VALUES (?, ?, ?, ?, ?)");
    $sql->execute([$user_id, $name, $email, $phone, $notes]);

    header("Location: dashboard.php");
    exit;
}


?>



<h3>Add Contact</h3>
<form method="post">
    <input class="form-control mb-2" name="name" placeholder="Name" required>
    <input class="form-control mb-2" name="email" placeholder="Email" required>
    <input class="form-control mb-2" name="phone" placeholder="Phone" required>
    <textarea class="form-control mb-2" name="notes" placeholder="Notes"></textarea>
    <button class="btn btn-success">Save</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'includes/footer.php'; ?>
