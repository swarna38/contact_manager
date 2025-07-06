<?php session_start();
include 'config.php';

//check user_id set or not session
//contact table for key user_id
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

//when click delete button contact information this url $_get
$delete_id = $_GET['id'];

$sql = $pdo->prepare('delete from contacts where id = ? AND user_id = ?');
$sql->execute([$delete_id, $_SESSION['user_id']]);

header("Location: dashboard.php");
exit;

?>