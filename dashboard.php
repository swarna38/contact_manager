<?php session_start();

   include 'config.php';
   include 'includes/header.php';

   $user_id = $_SESSION['user_id'];

    //check if session user id not set
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }else{

        $sql = $pdo->prepare("select * from contacts WHERE user_id = ?");
        $sql->execute([$_SESSION['user_id']]);
        $results = $sql->fetchAll();
    }

?>

<h2>My Contacts</h2>
<a href="add_contact.php" class="btn btn-success mb-3">+ Add Contact</a>
<a href="logout.php" class="btn btn-danger float-end mb-3">Logout</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>User Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <!-- ==== check if results exists then if block run and show data ===== -->
        <?php if($results){?>

            <?php foreach($results as $result){ ?>
                <tr>
                    <td><?= htmlspecialchars($result['user_id']) ?></td>
                    <td><?= htmlspecialchars($result['name']) ?></td>
                    <td><?= htmlspecialchars($result['email']) ?></td>
                    <td><?= htmlspecialchars($result['phone']) ?></td>
                    <td><?= htmlspecialchars($result['notes']) ?></td>

                    <td>
                        <a href="edit_contact.php?edit_id=<?php echo $result['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                        <a href="delete_contact.php?delete_id=<?php echo $result['id'] ?>" onclick="return confirm('Delete this contact?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>

        <?php }else{?>
            <!-- ====check if results blank means no contact then else block run ==== -->
             <tr>
                <td colspan="6" class="text-center text-muted ">
                You have no contacts yet. <a href="add_contact.php">Add one</a>
                </td>
             </tr>
        <?php }?>    
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>