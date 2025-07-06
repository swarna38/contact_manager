<?php session_start();

    include 'config.php';
    include 'includes/header.php';

    $error = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);

        $sql = $pdo->prepare("select * from users where username=?");
        $sql->execute([$username]);
        $user = $sql->fetch();

        //check user exists and password check with hashpassword
        //session user_id contacts table user_id
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        }else{
            $error = "Invalid username or password.";
        }
    }

?>


<!-- ====form start==== -->
<h3>Login</h3>
<form method="post">
    <input class="form-control mb-2" name="username" placeholder="Enter Your Username" required>
    <input type="password" class="form-control mb-2" name="password" placeholder="Enter Your Password" required>
    <button class="btn btn-primary">Login</button>
    <a href="registration.php" class="btn btn-secondary">Register</a>
</form>

<?php if(isset($error)) echo "<p class='text-danger mt-2'>$error</p>"; ?>

<!-- ====form end==== -->

<?php include 'includes/footer.php'; ?>