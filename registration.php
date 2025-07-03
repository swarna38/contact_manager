<?php 
    session_start();
    include 'config.php';
    include 'includes/header.php';

    $error = null;
    $success = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        //check empty
        if(empty($username) || empty($password)){
            $error = "Username and Password are required.";
        }else{
            $hashPass = password_hash($password, PASSWORD_DEFAULT);

            $sql = $pdo->prepare("select * from users where username=?");
            $sql->execute(['username']);

            //if check user exists or not 
            if($sql->fetch()){
                $error = "Username already exists.";
            }else{
                $sql_insert = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $sql_insert->execute([$username, $hashPass]);
                $success = "Registration successful.";
            }
        }
    }
?>

<!-- ====form start===== -->
<h3>Register</h3>
<form method="post">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
    <a href="login.php" class="btn btn-secondary">Login</a>
    <br>

    <?php
        //if error or success set 
        if(isset($error)){
            echo "<p class='text-danger mt-2'>$error</p>";
        }
        if(isset($success)){
            echo "<p class='text-success mt-2'>$success</p>";
        }
    ?>

</form>
<!-- ====form end===== -->




<?php include 'includes/footer.php'; ?>